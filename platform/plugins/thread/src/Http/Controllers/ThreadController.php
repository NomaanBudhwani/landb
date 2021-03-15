<?php

namespace Botble\Thread\Http\Controllers;

use App\Models\ThreadComment;
use App\Models\ThreadVariation;
use App\Models\VariationFabric;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Thread\Forms\ThreadDetailsForm;
use Botble\Thread\Http\Requests\ThreadRequest;
use Botble\Thread\Models\Thread;
use Botble\Thread\Repositories\Interfaces\ThreadInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Thread\Tables\ThreadTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Thread\Forms\ThreadForm;
use Botble\Base\Forms\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ThreadController extends BaseController
{
    /**
     * @var ThreadInterface
     */
    protected $threadRepository;

    /**
     * @param ThreadInterface $threadRepository
     */
    public function __construct(ThreadInterface $threadRepository)
    {
        $this->threadRepository = $threadRepository;
    }

    /**
     * @param ThreadTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(ThreadTable $table)
    {
        page_title()->setTitle(trans('plugins/thread::thread.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/thread::thread.create'));

        return $formBuilder->create(ThreadForm::class)->renderForm();
    }

    /**
     * @param ThreadRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ThreadRequest $request, BaseHttpResponse $response)
    {
        $requestData = $request->input();

        $requestData['order_no'] = strtoupper(Str::random(8));

        $thread = $this->threadRepository->createOrUpdate($requestData);

        $thread->product_categories()->sync($requestData['category_id']);

        event(new CreatedContentEvent(THREAD_MODULE_SCREEN_NAME, $request, $thread));

        return $response
            ->setPreviousUrl(route('thread.index'))
            ->setNextUrl(route('thread.edit', $thread->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $thread = $this->threadRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $thread));

        page_title()->setTitle(trans('plugins/thread::thread.edit') . ' "' . $thread->name . '"');

        return $formBuilder->create(ThreadForm::class, ['model' => $thread])->renderForm();
    }

    /**
     * @param int $id
     * @param ThreadRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ThreadRequest $request, BaseHttpResponse $response)
    {
        $thread = $this->threadRepository->findOrFail($id);

        $requestData = $request->input();

        $thread->fill($requestData);

        $this->threadRepository->createOrUpdate($thread);

        $thread->product_categories()->sync($requestData['category_id']);

        event(new UpdatedContentEvent(THREAD_MODULE_SCREEN_NAME, $request, $thread));

        return $response
            ->setPreviousUrl(route('thread.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $thread = $this->threadRepository->findOrFail($id);

            $this->threadRepository->delete($thread);

            event(new DeletedContentEvent(THREAD_MODULE_SCREEN_NAME, $request, $thread));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $thread = $this->threadRepository->findOrFail($id);
            $this->threadRepository->delete($thread);
            event(new DeletedContentEvent(THREAD_MODULE_SCREEN_NAME, $request, $thread));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    /**
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function cloneItem($id, BaseHttpResponse $response, Request $request)
    {
        $requestData = $this->threadRepository->findOrFail($id);

        $categories = $requestData->product_categories()->pluck('product_category_id')->all();

        unset($requestData->id);
        unset($requestData->created_at);
        unset($requestData->updated_at);
        unset($requestData->deleted_at);

        $requestData->order_no = strtoupper(Str::random(8));

        $thread = $this->threadRepository->createOrUpdate($requestData->toArray());

        $thread->product_categories()->sync($categories);

        event(new CreatedContentEvent(THREAD_MODULE_SCREEN_NAME, $request, $thread));

        return $response
            ->setPreviousUrl(route('thread.index'))
            ->setNextUrl(route('thread.edit', $thread->id))
            ->setMessage(trans('core/base::notices.create_success_message'));

    }

    public function show($id, Request $request, FormBuilder $formBuilder){
      $thread = Thread::with(['designer', 'season', 'vendor', 'fabric'])->find($id);
//dd($thread);
      event(new BeforeEditContentEvent($request, $thread));

      page_title()->setTitle('Thread Details' . ' "' . $thread->name . '"');

      return $formBuilder->create(ThreadDetailsForm::class, ['model' => $thread])->renderForm();
    }

    public function addVariation(Request $request){
      $data = $request->all();
      $thread = Thread::with(['designer', 'season', 'vendor', 'fabric'])->find($data['thread_id']);
      for ($i=0; $i<=count($data['name'])-1 ; $i++ ) {
        $variation = new ThreadVariation();
        $input = array();
        $input['thread_id'] = $data['thread_id'][$i];
        $input['name'] = $data['name'][$i];
        $input['print_id'] = $data['print_id'][$i];
        $input['regular_qty'] = $data['regular_qty'][$i];
        $input['plus_qty'] = $data['plus_qty'][$i];
        $input['cost'] = $data['cost'][$i];
        $input['notes'] = $data['notes'][$i];
        $input['status'] = 'active';
        $input['sku'] = generate_sku_by_thread_variation($thread);
        $input['created_by'] = Auth::user()->id;
        $create = $variation->create($input);
        if(!$create){
          return redirect()->back()->with('error', 'Error adding Variation(s)');
        }
      }
        return redirect()->back()->with('success', 'Variation(s) added successfully');


    }

    public function updateVariationStatus($id, $status){
     $update = ThreadVariation::find($id)->update(['status' => $status]);
      if($update){
        return redirect()->back()->with('success',  'Status updated');
      }else{
        return redirect()->back()->with('error',  'Server error');
      }
    }

    public function postComment(Request $request){
      $data = $request->all();
      $file = $request->file('image');
      if($file){
        $type = strtolower($file->getClientOriginalExtension());
        $image = str_replace(' ', '_' , $data['comment'].'_'. substr(microtime(), 2,7)).'.'.$type;
        $imageFile = Image::make($request->file('image'))->stream();
        $move = Storage::disk('public')->put('images/comments/' . $image, $imageFile);
        if($move){
          $data['image'] = 'storage/images/comments/' . $image;
        }
      }

      $input = ThreadComment::create($data);

      if($input){
        return redirect()->back()->with('success',  'Comment posted');
      }else{
        return redirect()->back()->with('error',  'Server error');
      }
    }

    public function addVariationPrints(Request $request){
      $data = $request->all();

      $data['created_by'] = Auth::user()->id;

      $input = VariationFabric::create($data);

      if($input){
        return redirect()->back()->with('success',  'Fabric added');
      }else{
        return redirect()->back()->with('error',  'Server error');
      }
    }

    public function removeFabric($id){

      $remove = VariationFabric::find($id)->delete();
      if($remove){
        return redirect()->back()->with('success',  'Fabric deleted');
      }else{
        return redirect()->back()->with('error',  'Server error');
      }
    }

}
