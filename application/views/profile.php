

<?php
$userid =  $this->session->userdata('id');
if(empty($userid))
{
    redirect('/user/login');
}
?>
<style>

.btn-round-lg{
border-radius: 22.5px;
}
.btn-round{
border-radius: 17px;
}
.btn-round-sm{
border-radius: 15px;
}
.btn-round-xs{
border-radius: 11px;
padding-left: 10px;
padding-right: 10px;
}
body {
  margin: 0;
  font-family: "Lato", sans-serif;
}
div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}
</style>
<section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Album</h1>
          <button type="button" class="btn btn-default btn-round-lg btn-lg" data-toggle="modal" data-target="#updateAlbum">Create Album</button>
          </p>
        </div>
      </section>
  <div class="col-md-4"></div>
  <div class="col-md-6">
            <div id="album-list">
              
               
            </div>
  </div>
  <div class="modal fade" id="updateAlbum" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Album</h4>
        </div>
        <div class="modal-body">
            <form method="post" id="album-form" action="">
            <div class="form-group">
                <label for="Name">Album Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
                            
                            <div class="form-group">
                                <label for="my-input">Album description</label>
                                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                            </div>
                
                
                        
                        <div class="form-group">
                                <button type="submit" id="createalbum" class="btn btn-primary" name="album-submit">Create Album</button>      
                        </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>

<script>
var base_url = "<?php echo base_url(); ?>";
$(document).ready(function()
{ 
  fetchallalbums();
  $("#album-form").submit(function()
  { 
    var name = $("#name").val();
    var description = $("#description").val();
    if(!name || !description)
    {
      alert("please enter the album details");
    }
    $.ajax
    ({
      url: "<?php echo base_url('index.php/album/update')?>",
      type:"post",
      data :
      {
        status:1,
        "name":name,
        "description":description

      },
      success:function(response)
      {
        if(response)
        {
          $("#name").val("");
          $("#description").val("");
          $("#updateAlbum").hide();
          fetchallalbums();
        }
      }
     
    });

  return false;  
  });

});
function fetchallalbums()
{
  $.ajax
    ({
      url: "<?php echo base_url('index.php/album/fetchalbums')?>",
      type:"get",
      success:function(response)
      { 
        console.log(response);
        var jsonobj = JSON.parse(response);
        var html = "";
        for(var i=0;i<jsonobj.album_details.length;i++)
        {
          var album = jsonobj.album_details[i];
          html += '<div class="col-xs-18 col-sm-6 col-md-3">';
          html += ' <div class="thumbnail">';
          html += ' <img src=""class="img-responsive">';
          html += '  <div class="caption">';
          html += '  <h4>'+album.description+'</h4>';
          html += '   <p>'+album.name+'</p>';
          html += '   <p><a href="'+base_url+'/index.php/image/getimages/'+album.id+'" class="btn btn-info btn-xs" role="button">View</a></p>';
          html += '  </div>\
                    </div>\
                </div>';

        }
        $('#album-list').html(html);

        console.log(jsonobj);
      },
      error: function(response)
      {
        console.log(response);
      }
     
    });
 
}
</script>