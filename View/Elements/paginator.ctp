<?php

if (!isset($url)) {
    $url = array();
}
echo $this->Paginator->first('<<', array('url' => $url));
echo ' &nbsp; ' . $this->Paginator->prev('<', array('url' => $url));
echo ' &nbsp; ' . $this->Paginator->numbers(array('url' => $url));
echo ' &nbsp; ' . $this->Paginator->next('>', array('url' => $url));
echo ' &nbsp; ' . $this->Paginator->last('>>', array('url' => $url));
