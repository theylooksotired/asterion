<?php
class ListObjects {

    public function __construct($objectName, $options=array()) {
        $this->objectName = $objectName;
        $this->object = new $objectName();
        $this->options = $options;
        $this->message = (isset($options['message'])) ? $options['message'] : '';
        $this->query = (isset($options['query'])) ? $options['query'] : '';
        $this->queryCount = (isset($options['queryCount'])) ? $options['queryCount'] : '';
        $this->results = (isset($this->options['results'])) ? intval($this->options['results']) : '';
        $this->populate();
    }

    public function get($value) {
        //Gets an attribute value
        return (isset($this->$value)) ? $this->$value : '';
    }

    public function first() {
        return (count($this->list)>0) ? $this->list[0] : '';
    }

    public function countTotal() {
        //Count the total number of elements in the list
        if (!isset($this->countTotal)) {
            if ($this->queryCount!='') {
                $result = Db::returnSingle($this->queryCount);
                $this->countTotal = $result['numElements'];
            } else {
                $this->countTotal = $this->object->countResultsObject($this->options);
            }
        }
        return $this->countTotal;
    }
    
    public function isEmpty() {
        //Check if the list is empty
        return (count($this->list)>0) ? false : true;
    }

    public function populate() {
        //Populate the list
        $page = (isset($_GET[PAGER_URL_STRING])) ? intval($_GET[PAGER_URL_STRING])-1 : 0;
        if ($this->query!='') {
            if ($this->results!='') {
                $this->options['query'] .= ' LIMIT '.($page*$this->results).', '.$this->results;
            }
            $this->list = $this->object->readListQuery($this->options['query']);
        } else {        
            if ($this->results!='') {
                $this->options['limit'] = ($page*$this->results).', '.$this->results;
            }
            $this->list = $this->object->readListObject($this->options);
        }
    }

    public function showList($options=array(), $params=array()) {
        //Show the list using the Ui object
        $message = (isset($options['message'])) ? $options['message'] : $this->message;
        $function = (isset($this->options['function'])) ? $this->options['function'] : 'Public';
        $function = (isset($options['function'])) ? $options['function'] : $function;
        $middle = (isset($options['middle'])) ? $options['middle'] : '';
        $html = '';
        if (count($this->list)>0) {
            $center = floor(count($this->list)/2)-1;
            $counter = 0;
            foreach($this->list as $item) {
                $params['counter'] = $counter + 1;
                $itemUiName = $this->objectName.'_Ui';
                $functionName = 'render'.ucwords($function);
                $itemUi = new $itemUiName($item);
                if ($counter == 0) $params['class'] = 'first';
                if ($counter == count($this->list)-1) $params['class'] = 'last';
                $html .= $itemUi->$functionName($params);
                if ($middle!='' && $counter == $center) {
                    $html .= $middle;
                }
                $params['class'] = '';
                $counter++;
            }
        } else {
            $html = $message;
        }
        return $html;
    }

    public function pager($options=array()) {
        //Render a pager for the list
        if (!isset($this->pagerHtml)) {
            $this->pagerHtml = '';
            $page = (isset($_GET[PAGER_URL_STRING])) ? intval($_GET[PAGER_URL_STRING]) : 0;
            $delta = (isset($options['delta'])) ? intval($options['delta']) : 5;
            $midDelta = ceil($delta/2);
            if ($this->results > 0 && $this->countTotal() > $this->results) {
                $totalPages = ceil($this->countTotal()/$this->results);
                if ($totalPages <= $delta) {
                    //The number of pages is equal or less than delta
                    $listFrom = 0;
                    $listTo = $totalPages - 1;
                    $listStart = false;
                    $listEnd = false;
                } else {
                    if ($page < $midDelta + 1) {
                        //The first pages of the list
                        $listFrom = 0;
                        $listTo = $delta;
                        $listStart = false;
                        $listEnd = true;
                    } else {
                        if ($page+$midDelta >= $totalPages-1) {
                            //The last pages of the list
                            $listFrom = $totalPages - $delta;
                            $listTo = $totalPages - 1;
                            $listStart = true;
                            $listEnd = false;
                        } else {
                            //The middle pages of the list
                            $listFrom = $page - $midDelta;
                            $listTo = $page + $midDelta;
                            $listStart = true;
                            $listEnd = true;                        
                        }                    
                    }
                }
                $html = '';
                for ($i=$listFrom; $i<=$listTo; $i++) {
                    $class = ($i+1==$page) ? 'pagerActive' : 'pager';
                    $class = ($i==0 && $page==0) ? 'pagerActive' : $class;
                    $html .= '<div class="'.$class.'">
                                <a href="'.Url::urlPage($i+1).'">'.($i+1).'</a>
                            </div>';
                }
                $htmlListStart = '';
                if ($listStart) {
                    $htmlListStart = '<div class="pager pagerStart">
                                        <a href="'.Url::urlPage(1).'">1</a>
                                    </div>
                                    <div class="pager pagerStart"><span>...</span></div>';
                };
                $htmlListEnd = '';
                if ($listEnd) {
                    $htmlListEnd = '<div class="pager pagerEnd"><span>...</span></div>
                                    <div class="pager pagerEnd">
                                        <a href="'.Url::urlPage($totalPages).'">'.$totalPages.'</a>
                                    </div>';
                };
                $this->pagerHtml = '<div class="pagerAll">
                                        '.$htmlListStart.'
                                        '.$html.'
                                        '.$htmlListEnd.'
                                        <div class="clearer"></div>
                                    </div>';
            }
        }
        return $this->pagerHtml;
    }

    public function showListPager($options=array(), $params=array()) {
        //Returns the list with a pager on top and another in the bottom
        $pager = $this->pager($options);
        $pagerTop = '';
        $pagerBottom = '';
        if ($pager != '') {
            $pagerTop = '<div class="listPagerTop">'.$pager.'</div>';
            $pagerBottom = '<div class="listPagerBottom">'.$pager.'</div>';
        }
        return '<div class="listWrapper">
                    '.$pagerTop.'
                    <div class="listContent">
                        '.$this->showList($options, $params).'
                    </div>
                    '.$pagerBottom.'
                </div>';

    }

}
?>