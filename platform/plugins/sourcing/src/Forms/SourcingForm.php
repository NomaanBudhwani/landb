<?php

namespace Botble\Sourcing\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Sourcing\Http\Requests\SourcingRequest;
use Botble\Sourcing\Models\Sourcing;

class SourcingForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Sourcing)
            ->setValidatorClass(SourcingRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])->add('notes', 'textarea', [
                'label'      => 'notes',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => 'notes',
                    'data-counter' => 120,
                ],
            ])->add('file', 'mediaImage', [
                'label'      => 'Select File',
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}