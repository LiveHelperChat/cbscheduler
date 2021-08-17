<?php

class erLhcoreClassModelCBSchedulerPhoneTransform
{
    use erLhcoreClassDBTrait;

    public static $dbTable = 'lhc_cbscheduler_phone_transforms';

    public static $dbTableId = 'id';

    public static $dbSessionHandler = 'erLhcoreClassExtensionCbscheduler::getSession';

    public static $dbSortOrder = 'DESC';

    public function getState()
    {
        return array(
            'id' => $this->id,
            'dep_id' => $this->dep_id,
            'country' => $this->country,
            'rules' => $this->rules,
        );
    }

    public function __toString()
    {
        return $this->user_id;
    }

    public function __get($var)
    {
        switch ($var) {

            case 'departments_names':
                $this->department_names = '';
                $items = [];
                foreach ($this->dep_id_array as $depId) {
                    $dep = erLhcoreClassModelDepartament::fetch($depId);
                    if ($dep instanceof erLhcoreClassModelDepartament) {
                        $items[] = $dep->name;
                    }
                }

                $this->department_names = implode(', ', $items);

                return $this->department_names;

            case 'dep_id_array':
            case 'country_array':
                $attr = str_replace('_array','',$var);
                if (!empty($this->{$attr})) {
                    $jsonData = json_decode($this->{$attr},true);
                    if ($jsonData !== null) {
                        $this->{$var} = $jsonData;
                    } else {
                        $this->{$var} = array();
                    }
                } else {
                    $this->{$var} = array();
                }
                return $this->{$var};

            case 'rules_array':
                $this->rules_array = [];

                if (!empty(trim($this->rules))) {
                    $rulesItems = explode("\n",trim($this->rules));
                    foreach ($rulesItems as $ruleItem) {
                        $ruleItemCombination = explode('==>',$ruleItem);
                        if (count($ruleItemCombination) == 2) {
                            $this->rules_array[] = $ruleItemCombination;
                        }
                    }
                }
                return $this->rules_array;

            default:
                ;
                break;
        }
    }

    public $id = null;

    public $dep_id = null;

    public $country = null;

    public $rules = '';
}

?>