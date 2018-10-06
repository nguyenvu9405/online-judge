<?php
class Validation
{
    private $rules, $errors = array(), $isError = false;

    function __construct($rules=array())
    {
        $this->rules = $rules;
    }

    function judge($data=array())
    {
        foreach ($this->rules as $key=>$rules)
        {
            $value = null;
            if (isset($data[$key])) $value = $data[$key];
            foreach($rules as $name=>$cond)
            {
                if ($name=='required')
                {
                    if (empty($value))
                    {
                        $this->addError($key,'This field is required');
                        break;
                    }
                }
                else if ($name=='regex')
                {
                    $ex="/".$cond['ex']."/";
                    if (!preg_match($ex,$value))
                    {
                        $this->addError($key,$cond['guide']);
                        break;
                    }
                }
                else if ($name=='match')
                {
                    $field = $cond['field'];
                    if ($value != $data[$field])
                    {
                        $this->addError($key,$cond['guide']);
                        break;
                    }
                }
                else if ($name=='unique')
                {
                    $table = $cond['table'];
                    $field = $cond['field'];
                    if ($cond["where"]) $where = $cond["where"];
                    else $where = "";
                    $db = DB::getInstance();
                    if (!$db->select($table,"$field=?".$where,array($value)))
                        die("Errors: ".$db->getError());
                    else
                    {

                        if ($db->count())
                        {
                            $this->addError($key,$cond['guide']);
                            break;
                        }
                    }
                }
                else if ($name=='suffix')
                {
                    $arr = $cond['value'];
                    $ok = false;
                    foreach ($arr as $a)
                    {
                        if (Functions::endWith($value,$a))
                        {
                            $ok=true;
                            break;
                        }
                    }
                    if (!$ok) $this->addError($key,$cond['guide']);
                }
                else if ($name=='number')
                {
                    if (!is_numeric($value))
                    {
                        $this->addError($key,$cond['guide']);
                    }
                }
                else if ($name=='max')
                {
                    if ($value > $cond['value'])
                    {
                        $this->addError($key,$cond['guide']);
                    }
                }
                else if ($name=='min')
                {
                    if ($value < $cond['value'])
                    {
                        $this->addError($key,$cond['guide']);
                    }
                }
                else if ($name=="array")
                {
                    $size = count($value);
                    if ($size< $cond["min-length"] || $size>$cond["max-length"])
                    {
                        $this->addError($key,$cond["guide"]);
                    }
                }

            }
        }
        return !$this->isError;
    }

    private function addError($field,$error)
    {
        $this->errors[$field]= $error;
        if (!$this->isError) $this->isError = true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public static $Register =array(
        'name'=>array(
            'required'=>true,
            'regex'=>array(
                'ex'=>'^.{3,50}$',
                'guide'=>'Use 3-50 characters'),
        ),
        'username'=>array(
            'required'=>true,
            'regex'=>array(
                'ex'=>'^[a-zA-Z0-9._]{8,20}$',
                'guide'=>'Use 8-20 characters. Include letters, numbers, dots or underscore'),
            'unique'=>array(
                'table'=>'users',
                'field'=>'username',
                'guide'=>'Your username is already used'
            )
        ),
        'password'=>array(
            'required'=>true,
            'regex'=>array(
                'ex'=>"^[a-zA-Z0-9._]{8,20}$",
                'guide'=>'Use 8-20 characters. Include letters, numbers, dots or underscore'),

        ),
        'password_again'=>array(
            'required'=>true,
            'match'=>array(
                'field'=>'password',
                'guide'=>'The confirmed passwords did not match each other')
        ),
        'email'=>array(
            'required'=>true,
            'regex'=>array(
                'ex'=>'^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$',
                'guide'=>'Your email is in invalid form')
        ),
        'workplace'=>array(
            'regex'=>array(
                'ex'=>'^.{0,50}$',
                'guide'=>'Use 50 characters at maximum'
            )
        ),
        'birthday'=>array()
    );

    function judgeFile($file,$field)
    {
        switch ($file["error"])
        {
            case UPLOAD_ERR_INI_SIZE:
                $this->addError($field,"The uploaded file should be less than 25mb");
                return false;
            case UPLOAD_ERR_FORM_SIZE:
                $this->addError($field,"The uploaded file should be less than 25mb");
                return false;
            case UPLOAD_ERR_PARTIAL:
                $this->addError($field, "The uploaded file was only partially uploaded. Please try again");
                return false;
            case UPLOAD_ERR_NO_FILE:
                $this->addError($field, "No file was uploaded. Please try again");
                return false;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->addError($field, "System error. Please try again later");
                return false;
            case UPLOAD_ERR_CANT_WRITE:
                $this->addError($field,"System error. Please try again later");
                return false;
            default:
                if ($file["error"]!=0)
                {
                    $this->addError($field, "Cannot upload the file. Unknown issue");
                }


        }
        //  die(var_dump($this->rules));
        foreach ($this->rules as $key=>$conds)
        {
            $value = $file[$key];
            foreach ($conds as $name=>$cond)
            if ($name=="min")
            {
                if ($value < $cond["value"])
                {
                    $this->addError($field,$cond["guide"]);
                    return false;
                }
            }
            else if ($name=="max")
            {
                if ($value > $cond["value"])
                {
                    $this->addError($field,$cond["guide"]);
                    return false;
                }
            }
            else if ($name=="equal")
            {
                if ($value != $cond["value"])
                {
                    $this->addError($field,$cond["guide"]);
                    return false;
                }
            }
        }

        return true;
    }

    public static $ProblemTestcase = array(
        /*"type"=>array(
            "equal"=>array(
                "value"=>"application/zip",
                'guide'=>'The uploaded file need to be .zip file'
            )
        ),*/
        'size'=>array(
            'min'=>array(
                'value'=>1,
                'guide'=>'This field is required'
            ),
            'max'=>array(
                'value'=>25*1000*1000,
                'guide'=>'The maximum size of the file is 25mb'
            )
        ),
        'guide'=>'Upload .zip file containing all of testcases. The file should be less than 25mb'
    );

    public static $ProblemTags = array(
        "tags"=>array(
            "array"=>array(
                "min-length"=> 1,
                "max-length"=> 5,
                "guide"=>"Use at least 1 tag and maximum 5 tags to categorize your problem"
            ),
            "guide"=>"Use at least 1 tag and maximum 5 tags to categorize your problem"
        )
    );
    public static $ProblemProperties =  array(
        'title'=>array(
            'required'=>true,
            'regex'=>array(
                'ex'=>'^.{3,50}$',
                'guide'=>'Use 3-50 characters')
        ),
        'code'=>array(
            'required'=>true,
            'regex'=>array(
                'ex'=>'^[A-Z0-9]{3,12}$',
                'guide'=>'Use 3-12 uppercase letters and numbers'
            ),
            'unique'=>array(
                'table'=>'problems',
                'field'=>'code',
                'guide'=>'This code is already used'
            )
        ),
        'definition'=>array(
            'required'=>true
        ),
        "output_name"=>array(
            "regex"=>array(
                "ex"=>'^[a-zA-Z0-9.]{1,16}$',
                "guide"=>'Use 1-16 characters. Include letters, number and dot'
            )
        ),
        "input_name"=>array(
            "regex"=>array(
                "ex"=>"^[a-zA-Z0-9.]{1,16}$",
                "guide"=>'Use 1-16 characters. Include letters, number and dot '
            )
        ),
        "timelimit"=>array(
            "number"=>array(
                'guide'=>'This must be a number between 1-10'
            ),
            "min"=>array(
                'value'=>1,
                'guide'=>'Use a number higher than or equal 0'
            ),
            "max"=>array(
                'value'=>10,
                'guide'=>'Use a number less than or equal 10'
            ),
            "guide"=>"Use a number between 1-10 to specify timelimit in seconds"
        ),
        "memorylimit"=>array(
            "number"=>array(
                'guide'=>'This must be a number between 1-10'
            ),
            "min"=>array(
                'value'=>64,
                'guide'=>'Use a number higher than or equal 64'
            ),
            "max"=>array(
                'value'=>1024,
                'guide'=>'Use a number less than or equal 1024'
            ),
            "guide"=>"Use 64-1024 to specify memory limit in megabytes"
        )
    );


}