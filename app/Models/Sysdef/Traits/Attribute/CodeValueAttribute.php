<?php

namespace App\Models\Sysdef\Traits\Attribute;

use Carbon\Carbon;
/**
 * Class CodeValueAttribute
 */
trait CodeValueAttribute {

    /**
     * @return string
     * Is Active attribute
     */
    public function getActiveAttribute()
    {
        if ($this->is_active()){
            return 'true';
        }else {
            return 'false';
        }

    }

    /**
     * @return string
     * is Mandatory attribute
     */
    public function getMandatoryAttribute()
    {
        if ($this->is_mandatory()){
            return 'true';
        }else {
            return 'false';
        }

    }

    /**
     * @return string
     */
    // public function getEditButtonAttribute() {
    //     if (!$this->is_mandatory()) {
    //     return '<a href="' . route('backend.system.code.edit_value', $this->id) . '" class="btn btn-xs btn-primary save_button" ><i class="icon fa fa-edit" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a> ';
    //     }
    // }



    /**
     * @return string
     */
//     public function getDeleteButtonAttribute() {
// if (!$this->is_mandatory()) {
//     return '<a href="' . route('backend.system.code.delete_value',
//             $this->id) . '" class="btn btn-xs btn-danger delete_button" data-trans-button-cancel="' . trans('buttons.general.cancel') . '" data-trans-button-confirm="' . trans('buttons.general.confirm') . '" data-trans-title="' . trans('labels.general.warning') . '" data-trans-text="' . trans('strings.backend.general.delete_message') . '" data-method="delete" ><i class="icon fa fa-trash-o" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.delete') . '"></i></a>';


// }
//     }




    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return  $this->getEditButtonAttribute();

    }



    public function is_mandatory(){
return $this->is_mandatory == 1;
    }

    public function is_active(){
        return $this->is_active == 1;
    }


}
