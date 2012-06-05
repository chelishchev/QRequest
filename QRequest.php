<?php
/**
 * @author Ivan Chelishchev <chelishchev@gmail.com>
 */
class QRequest extends CHttpRequest
{
    /**
     * @param $name Есть возможность обращаться к вложенному массиву: Example[0][name]
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getParam($name, $defaultValue = null)
    {
        $name = $this->_reformatNameToPath($name);
        $val  = self::getFromArrayByKey($name, $_GET);
        if(is_null($val))
        {
            $val = self::getFromArrayByKey($name, $_POST);
        }

        return is_null($val) ? $defaultValue : $val;
    }

    /**
     * @param $name Есть возможность обращаться к вложенному массиву: Example[0][name]
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getQuery($name, $defaultValue = null)
    {
        $name = $this->_reformatNameToPath($name);
        $val  = self::getFromArrayByKey($name, $_GET);

        return is_null($val) ? $defaultValue : $val;
    }

    /**
     * @param $name Есть возможность обращаться к вложенному массиву: Example[0][name]
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getPost($name, $defaultValue = null)
    {
        $name = $this->_reformatNameToPath($name);
        $val  = self::getFromArrayByKey($name, $_POST);

        return is_null($val) ? $defaultValue : $val;
    }

    /**
     * Преобразуем в путь Example[0][name] => Example.0.name
     * @param $name
     * @return string
     * @author Ivan Chelishchev <chelishchev@gmail.com>
     */
    protected function _reformatNameToPath($name)
    {
        //Example[0][name] => Example.0.name
        return strtr($name, array(
                                 '[' => '.',
                                 ']' => '',
                            )
        );
    }

    /**
     * Получение по вложенному ключу значения массива.
     * Ключи передаются в строке соединенные через $delimiter. В случае не находа отдается null
     * @static
     * @param $key
     * @param array $array
     * @param string $delimiter
     * @return mixed
     * @author Ivan Chelishchev <chelishchev@gmail.com>
     */
    public static function getFromArrayByKey($key, array &$array, $delimiter = '.')
    {
        //разделяю на массив ключей и удаляю . которые лишние
        $partKeys = explode($delimiter, trim($key, $delimiter));
        $tmp      = &$array;
        $lastKeys = end($partKeys);
        foreach($partKeys as $partKey)
        {
            //если данный ключ существует, то идем в глубь дальше
            if(is_array($tmp) && array_key_exists($partKey, $tmp))
            {
                //если это последний ключ, то вернем по нему искомое значение
                if($lastKeys === $partKey)
                {
                    return $tmp[$partKey];
                }
                //ссылаемся на вложенный массив
                $tmp = &$tmp[$partKey];
            }
            //если такого ключа не существует, то выходим
            else
            {
                break;
            }
        }
        unset($partKey, $tmp);

        return null;
    }
}
