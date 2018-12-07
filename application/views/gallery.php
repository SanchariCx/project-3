<?php
if(empty($this->session->userdata('id')))
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
.navbar {

    margin-bottom: 0px;
}

#images-wrapper img {    
   width: 100% ;    
   height: auto !important;  
}  
#images-wrapper{    
   display:inline-block;    
   margin-right: auto;    
   margin-left: auto;  
}

</style>
<?php
if(isset($album)&&!empty($album))
{
    foreach($album as $value)
    {

    
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Image Gallery</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Album</a></li>
      <li><a href="<?php echo base_url('index.php/user/logout')?>">Logout</a></li>
      <li><a href="<?php echo base_url('index.php/image/trash/'.$value['id'])?>">Trash</a></li>
    
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>
  <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Gallery</h1>
          <button type="button" class="btn btn-default btn-round-lg btn-lg" data-toggle="modal" data-target="#ImageUpload">Image Upload</button>
          <button type="button" class="btn btn-default btn-round-lg btn-lg" data-toggle="modal" data-target="#AlbumUpdate">Album Update</button>
          </p>
        </div>
      </section>
     
      <?php
      $error =  $this->session->flashdata('error');
      if(!empty($error))
      {?>
        <script>
            $(document).ready(function()
            {
            $('#ImageUpload').modal('show');
            });
            
        </script>
      <?php
      }

      ?>
<div class="col-md-6 col-md-offset-3">
        <div class="col-xs-12 col-sm-10">
                    <div class="row">
                       
</div>
</div>
</div>
<div class="modal fade" id="ImageUpload">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <?php
               echo $this->session->flashdata('error'); 
                ?>
            <form  class="form-inline"  enctype="multipart/form-data" method="post" id="ImageUploadForm">
                <div class="form-group">
                    <label class="btn btn-default btn-file">
                            upload Image <input type="file" style="display: none;"  name="album-image" id="album-image"> 
                    </label>
                </div>
                <div class="form-group">
                    <label for="caption">Caption</label>
                    <input type="text" class="form-control" name="caption">
                </div>
                <div class="form-group">
                <select name="view_status" id="input" class="form-control">
                        <option value="">-- Privacy --</option>
                        <option value="1">public</option>
                        <option value="0">private</option>
                    </select>

                </div>
            <div class="form-group">
            <input type="submit" value="Save" name="image-upload">
            </div>
            </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="AlbumUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
            <form id="albumupdateform" method="post">
            <div class="form-group">
                <label for="name">Album Name</label>
                <input id="name" class="form-control" type="text" name="name">
            </div>
            <div class="form-group">
                <label for="description">Text</label>
                <input id="description" name="description"class="form-control" type="text" >
            </div>
            <div class="form-group">
            <input type="submit" value="Save" name="update-album">
            </div>
            </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
}
}
?>
<script>
$(document).ready(function()
{   
    var album_id = "<?php echo $album[0]['id']?>";
    
    $('#ImageUploadForm').submit(function(){
        var formdata  = new FormData(this);
        formdata.append('album_id', album_id);
        $.ajax({
            type:'POST',
            url:"<?php echo base_url('index.php/image/do_upload') ?>",
            data:formdata,
            cache:false,
            contentType:false,
            processData:false,
            success:function(data){
               console.log(data);
               $('#ImageUpload').hide();
               ImageList(); 

            },
            error:function(data){
               console.log(data);
            }
        });

        return false;    
    });
   
    $("#albumupdateform").submit(function()
    { 
    var name = $("#name").val();
    var description = $("#description").val();
     $.post
    (
        "<?php echo base_url('index.php/album/update')?>",
      {
        status:1,
        "name":name,
        "description":description,
        "id":album_id

      },
      function(response)
      {
        if(response)
        { 
            $("#AlbumUpdate").hide();
        
        }
      }
     
    );

    return false;  
    });


});
function ImageList()
{   var base_url = "<?php echo base_url(); ?>";
    var album_id = "<?php echo $album[0]['id']?>";
        $.ajax({
            type:'POST',
            url:"<?php echo base_url('index.php/image/fetchimages')?>",
            data:{
             albumid:album_id   
            },
            success:function(response)
            {
                console.log(response);
                var jsonobj = JSON.parse(response);
                var html = "";
                for(var i =0;i<jsonobj.images.length;i++)
                {   var image_id = jsonobj.images[i]['id'];
                    html+= '<div id="images-wrapper">';
                    html+= ' <div class="thumbnail">';
                    html+= '  <form action="'+base_url+'index.php/image/softdelete/'+image_id+'" method="post">';
                    
                }
               


            },
            error:function(response)
            {
                console.log(response);
            }

        });
}

</script>