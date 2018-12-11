<style>
body
{
    overflow:auto;
    padding: 0px;
}
.btn-round-lg{
border-radius: 22.5px;
}
.navbar {
    margin-bottom: 0px;
}
.images-wrapper{    
   display:inline-block;    
   margin-right: auto;    
   margin-left: auto;  
}
.images-wrapper img {    
   width: 100% ;    
   height: auto !important;  
}  


</style>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Image Gallery</a>
    </div>
    <ul class="nav navbar-nav">
    <?php
    if(isset($album)&&!empty($album))
    {
        foreach($album as $value)
        {
    ?>
      <li class="active"><a href="<?php echo base_url('index.php/album')?>">Album</a></li>
      <li><a href="<?php echo base_url('index.php/user/logout')?>">Logout</a></li>
      <li><a href="<?php echo base_url('index.php/image/trash/'.$value['id'])?>">Trash</a></li>
    <?php
        }
    }    
    ?>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>
  <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Gallery</h1>
          <?php
          if(!empty($this->session->userdata['id']))
          {
            ?>   
            <button type="button" class="btn btn-default btn-round-lg btn-lg" data-toggle="modal" data-target="#ImageUpload">Image Upload</button>
          <button type="button" class="btn btn-default btn-round-lg btn-lg" data-toggle="modal" data-target="#AlbumUpdate">Album Update</button>
          <?php
          } 
          ?>
          
          </div>
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
<div class="col-md-10 col-md-offset-1">
        <div class="col-xs-12 col-sm-10">
                    <div class="row">
                       <div id="image-list">
                       </div>
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

<script>
 <?php if(!empty($album)) : ?>
    var album_id = "<?php echo $album[0]['id']?>";
    ImageList();
    function ImageList()
    {

        var base_url = "<?php echo base_url(); ?>";
        var image_path = "<?php echo FCPATH?>";
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
                {   
                    var image = jsonobj.images[i];
                    html+= '<div class="images-wrapper" id="'+image.id+'-div">';
                    html+= ' <div class="thumbnail">';
                    html+= '  <a href="" data-fancybox data-caption="&lt;b&gt;Single photo&lt;/b&gt;&lt;br /&gt;Caption can contain &lt;em&gt;any&lt;/em&gt; HTML elements">';
                    html+= '    <img src="/project-3/'+'images/thumbnail/'+image.image_name+'" class="img-responsive" alt="card-img-top"style="width:100%;">';
                    html+= '     </a>';
                    html+= '     <div class="caption">';
                    html+= '      <p>'+image.caption+'</p>';
                    html+= '       <button type="submit" class="btn btn-info" name="delete-image" onclick ="deleteimage('+image.id+')">Delete</button>';
                    html+= '       </div>\
                                      </div>\
                                      </div>';
                   
                    $('#image-list').html(html);
                                   
                }
               

            },
            error:function(response)
            { 
                console.log(response);
            }

        });
    }
<?php else: ?>
    publicImageList();
    function publicImageList()
{   
    var base_url = "<?php echo base_url(); ?>";
    var image_path = "<?php echo FCPATH?>";
        $.ajax({
            type:'POST',
            url:"<?php echo base_url('index.php/image/fetchPublicImages')?>",
            success:function(response)
            {
                console.log(response);
                var jsonobj = JSON.parse(response);

                var html = "";
                for(var i =0;i<jsonobj.images.length;i++)
                {   

                    var image = jsonobj.images[i];
                    html+= '<div class="images-wrapper" id="'+image.id+'-div">';
                    html+= ' <div class="thumbnail">';
                    html+= '  <a href="" data-fancybox data-caption="&lt;b&gt;Single photo&lt;/b&gt;&lt;br /&gt;Caption can contain &lt;em&gt;any&lt;/em&gt; HTML elements">';
                    html+= '    <img src="/project-3/'+'images/thumbnail/'+image.image_name+'" class="img-responsive" alt="card-img-top"style="width:100%;">';
                    html+= '     </a>';
                    html+= '     <div class="caption">';
                    html+= '      <p>'+image.caption+'</p>';
                    html+= '       </div>\
                                      </div>\
                                      </div>';
                   
                    $('#image-list').html(html);
                                   
                }
               

            },
            error:function(response)
            { 
                console.log(response);
            }

        });
}
    <?php endif; ?>
window.onload = $(document).ready(function()
{   
    <?php if(empty($user_id)):?>
    publicImageList();     
<?php endif;?>
    //image upload
    $('#ImageUploadForm').submit(function(){
        
        var uploadform = $('#ImageUpload');
        var btn =  uploadform.find("input[type='submit']");
        btn.val('uploading...');
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
                if(data)
                {   btn.val('save');
                    ImageList();
                    $('#ImageUpload').hide();
                    
                }
               console.log(data);

            

            },
            error:function(data){
               console.log(data);
            }
        });

        return false;    
    });
    
   
    //albumupdate    
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




function deleteimage(imageid)
{   
    var imagediv = $('#'+imageid+"-div");
    var btn =  imagediv.find("button[type='submit']");
    btn.attr('disabled',true);
    setTimeout(function(){
        $.post
        (
            "<?php echo base_url('index.php/image/softdelete')?>",
        {
            status:1,
            "id": imageid

        },
        function(response)
        {   
            btn.attr('disabled',false); 
          if(response)
          {
            imagediv.remove();
          }
        }
        
        );

    },1);
    
   
}

</script>