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
        $criteria['tmpl_id']          = $payload['tmpl_id'];
        $criteria['tmpl_folder_id']   = $payload['folder_id'];
        $criteria['tmpl_cat_id']      = $payload['cat_id'];
        $criteria['tmpl_name']        = $payload['tmpl_name'];
        $criteria['tmpl_message']     = $payload['tmpl_message'];
        $criteria['tmpl_media_id']    = $payload['tmpl_media_id'];
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
}
?>
