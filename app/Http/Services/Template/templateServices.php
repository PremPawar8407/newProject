<?php

namespace App\Http\Services\Template;


use Illuminate\Support\Facades\Request;
use App\Models\templateModel;

class templateServices 
{
    function validCatID($payload)
    {
        return templateModel::validCatID($payload);
    }

    function validTmplName($payload)
    {
        return templateModel::validTmplName($payload);
    }

    function addMedia($payload)
    {
            return templateModel::addMedia($payload);
    }

    function addTemplate($payload, $usrId)
    {
            $tmplID = templateModel::addTemplate($payload);
            if($payload['tmpl_type'] == "DRIP")
            {
                foreach($payload['tmpl_drip_details'] as $drip)
                {

                   if( array_key_exists("drp_media_url", $drip) && $drip['drp_media_url'] != null)
                   {
                        $drip['drp_media_id'] = $this->addMedia(array('media_title' => $drip['drp_media_title'], 'media_url' => $drip['drp_media_url'], 'media_source' => "TEMPLATE_DRIP", 'media_created_on' => date(getenv("DATETIME_FORMAT")), 'media_created_by' => $usrId));
                    }
                    if ($drip['drp_media_url'] == null) 
                    {
                        $drip['drp_media_id'] = 0;

                    }
                   
                        $drpData = array('drp_tmpl_id' => $tmplID, 'drp_type' => $drip['drp_type'], 'drp_media_id' => $drip['drp_media_id'], 'drp_message' => $drip['drp_message'], 'drp_created_on' => date(getenv("DATETIME_FORMAT")), 'drp_created_by' => $usrId);

                        if(array_key_exists("drp_days", $drip))
                        $drpData['drp_days'] = $drip['drp_days'];
                        if(array_key_exists("drp_hours", $drip))
                        $drpData['drp_hours'] = $drip['drp_hours'];
                        if(array_key_exists("drp_minutes", $drip))
                        $drpData['drp_minutes'] = $drip['drp_minutes'];
                        if(array_key_exists("drp_meridiem", $drip))
                        $drpData['drp_meridiem'] = $drip['drp_meridiem'];

                    $addDripMsg = templateModel::addDripMsg($drpData);
                    
                }
            }

            return $tmplID;
    }

    public function checkValidTmplId($tmplID, $usrId)
    {
        return templateModel::checkValidTmplId($tmplID, $usrId);
    }

    public function updateTemplate($payload)
    {   
        if (array_key_exists('tmpl_media_id', $payload)) 
        {
            $criteria['tmpl_media_id']    = $payload['tmpl_media_id'];
        }
       
        $criteria['tmpl_id']          = $payload['tmpl_id'];
        $criteria['tmpl_folder_id']   = $payload['folder_id'];
        $criteria['tmpl_cat_id']      = $payload['cat_id'];
        $criteria['tmpl_name']        = $payload['tmpl_name'];
        $criteria['tmpl_message']     = $payload['tmpl_message'];
        $criteria['tmpl_modified_on'] = date(getenv("DATETIME_FORMAT"));
        $criteria['tmpl_modified_by'] = $payload['account_id'];
       
       return templateModel::updateTemplate($criteria);
        

    }

    public function templateListAll($payload)
    {
        return templateModel::templateListAll($payload);
    }

    public function templateListAllUsrId($payload)
    {
        return templateModel::templateListAllUsrId($payload);
    }

    public function dripMsgList($payload)
    {
        return templateModel::dripMsgList($payload);
    }

    public function fetchTemplateDetails($tmplID)
    {   
        $templateDetails = templateModel::fetchTemplateDetails($tmplID);
         if(count($templateDetails) > 0)
        {
            $templateDetails = (array) $templateDetails[0];
            //if template type if DRIP then fetch drip details...
            if($templateDetails['tmpl_type'] == "DRIP")
                $templateDetails['drip_details'] = templateModel::dripMsgList(array("tmpl_id" => $tmplID));
        }
        return $templateDetails;
    }

    function templateDelete($payload)
    {
        if (array_key_exists('tmpl_id', $payload)) 
        {
            $tmplID = $payload['tmpl_id'];
        }

        $criteria['tmpl_deleted_on'] = date(getenv("DATETIME_FORMAT"));
        $criteria['tmpl_deleted_by'] = $payload['account_id'];
        return templateModel::templateDelete($tmplID, $criteria);
    }


    function updateDripMessages($payload)
    {
        if (array_key_exists('drp_type', $payload)) 
        {
            $criteria['drp_type'] = $payload['drp_type'];
        }
         if (array_key_exists('drp_days', $payload)) 
        {
            $criteria['drp_days'] = $payload['drp_days'];
        }

        if (array_key_exists('drp_hours', $payload)) 
        {
            $criteria['drp_hours'] = $payload['drp_hours'];
        }

        if (array_key_exists('drp_minutes', $payload)) 
        {
            $criteria['drp_minutes'] = $payload['drp_minutes'];
        }
        if (array_key_exists('drp_meridiem', $payload)) 
        {
            $criteria['drp_meridiem'] = $payload['drp_meridiem'];
        }
         if (array_key_exists('drp_message', $payload)) 
        {
            $criteria['drp_message'] = $payload['drp_message'];
        }
        if (array_key_exists('drp_media_id', $payload)) 
        {
            $criteria['drp_media_id'] = $payload['drp_media_id'];
        }
            
        $criteria['drp_modified_on'] = date(getenv("DATETIME_FORMAT"));
        $criteria['drp_modified_by'] = $payload['account_id'];

        return templateModel::updateDripMessages($payload['drp_id'], $criteria);
        
    }

    function deleteDripMessages($payload)
    {
        return templateModel::deleteDripMessages($payload);
        
    }
}
?>
