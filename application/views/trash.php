<style>
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
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Image Gallery</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href = "<?php echo base_url('index.php/album/')?>">Album</a></li>
      <li><a href="<?php echo base_url('index.php/user/logout')?>">Logout</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>
<div class="col-md-6 col-md-offset-3">
        <div class="col-xs-12 col-sm-10">
                    <div class="row">
                        <?php
                        if(isset($trashed_data)&&!empty($trashed_data))
                        {
                            foreach($trashed_data as $image)
                            {            
                        ?>
                                 <div id="images-wrapper">
                                        <div class="thumbnail">
                                            <form action="<?php echo base_url('index.php/image/trashdelete/'.$image['id'])?>" method="post">
                                                    <a href="" data-fancybox data-caption="&lt;b&gt;Single photo&lt;/b&gt;&lt;br /&gt;Caption can contain &lt;em&gt;any&lt;/em&gt; HTML elements">
                                                        <img src="<?php echo base_url('images/thumbnail/'.$image['image_name'].'_thumb.'.$image['ext'])?>"class="img-responsive" alt="card-img-top"style="width:100%;">
                                                    </a>
                                                    <div class="caption">   
                                                        <h4><?=$image['caption']?></h4>
                                                        <p>Caption...</p>
                                                        <input type="hidden" name="imagename" value="<?=$image['image_name']?>">
                                                        <input type="hidden" name="extension" value="<?=$image['ext']?>">
                                                        <button type="submit" class="btn btn-info" name="delete-image">Permanent Delete</button>        
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                    <?php
                                
                            }
                        }    
                    ?>
</div>
</div>
</div>
