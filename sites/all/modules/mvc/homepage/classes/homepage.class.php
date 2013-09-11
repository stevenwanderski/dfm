<?php
// class file myclass.class.php
class Homepage{

    public function index(){
        print "Hello, this is my Prometheus class front page";
    }

    public function hello ( $input ){
        // print "Hello: $input";
      return array('foo' => 'bar');
    }

    public function category ( $category1, $category2 ){
        print "Categories are $category1, $category2";
    }

    // url to access this page would be
    // **replace _ with - for public access
    public function show_my_list(){
        print "my list";
    }

}
?>