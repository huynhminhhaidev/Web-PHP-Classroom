$(document).ready(function(){
  $("a.delete").click(function(e){
      if(!confirm('Bạn Có Chắc Muốn Xóa Không?')){
          e.preventDefault();
          return false;
      }
      return true;
  });
});
