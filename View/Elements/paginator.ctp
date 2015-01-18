<ul class="pagination pagination-sm no-margin">
<?php
if (!isset($url)) {
    $url = array();
}
$currentPage = isset($this->request->params['paging'][key($this->request->params['paging'])]['page']) ? $this->request->params['paging'][key($this->request->params['paging'])]['page'] : 1;
if($currentPage > 1) {
    echo $this->Paginator->first('<<', array('url' => $url, 'tag' => 'li'));
    echo ' &nbsp; ' . $this->Paginator->prev('<', array('url' => $url, 'tag' => 'li'));
    
}
echo ' &nbsp; ' . $this->Paginator->numbers(array('url' => $url, 'tag' => 'li', 'separator' => '', 'currentTag' => 'span'));
echo ' &nbsp; ' . $this->Paginator->next('>', array('url' => $url, 'tag' => 'li'));
echo ' &nbsp; ' . $this->Paginator->last('>>', array('url' => $url, 'tag' => 'li'));

?>    
</ul>