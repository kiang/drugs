<ul class="pagination-plain">
<?php
if (!isset($url)) {
    $url = array();
}
$currentPage = isset($this->request->params['paging'][key($this->request->params['paging'])]['page']) ? $this->request->params['paging'][key($this->request->params['paging'])]['page'] : 1;
if($currentPage > 1) {
    // echo $this->Paginator->first('<<', array('url' => $url, 'tag' => 'li'));
    echo ' &nbsp;<span class="fui-arrow-left"></span>' . $this->Paginator->prev('← 往前', array('url' => $url, 'tag' => 'li', 'class' => 'previous'));
}
echo $this->Paginator->numbers(array('url' => $url, 'tag' => 'li', 'separator' => '', 'currentClass' => 'a','currentClass' => 'active'));
echo $this->Paginator->next('往後 →', array('url' => $url, 'tag' => 'li', 'class' => 'next'));
// echo ' &nbsp; ' . $this->Paginator->last('>>', array('url' => $url, 'tag' => 'li'));

?>    
</il>
<!-- 
<ul class="pagination-plain">
  <li class="previous"><a href="#fakelink">← Previous</a></li>
  <li><a href="#fakelink">1</a></li>
  <li><a href="#fakelink">2</a></li>
  <li><a href="#fakelink">3</a></li>
  <li><a href="#fakelink">4</a></li>
  <li class="active"><a href="#fakelink">5</a></li>
  <li><a href="#fakelink">6</a></li>
  <li><a href="#fakelink">7</a></li>
  <li><a href="#fakelink">8</a></li>
  <li><a href="#fakelink">9</a></li>
  <li><a href="#fakelink">10</a></li>
  <li class="next"><a href="#fakelink">Newer →</a></li>
</ul> -->