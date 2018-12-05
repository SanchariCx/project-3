<style>
.navbar {

margin-bottom: 0px;
}
</style>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Image Gallery</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Album</a></li>
      <li><a href="<?php echo base_url('index.php/image/trash/')?>">Trash</a></li>
      <li><a href="<?php echo base_url('index.php/image/trash/')?>">Trash</a></li>
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
                                <div class="col-xs-18 col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <form action="<?php echo base_url('index.php/image/softdelete/'.$image['id'])?>" method="post">
                                            <a href="" data-fancybox data-caption="&lt;b&gt;Single photo&lt;/b&gt;&lt;br /&gt;Caption can contain &lt;em&gt;any&lt;/em&gt; HTML elements">
                                                <img src="<?php echo base_url('images/thumbnail/'.$image['image_name'].'_thumb.'.$image['ext'])?>"class="img-responsive" alt="card-img-top"style="width:100%;">
                                            </a>
                                                    <div class="caption">   
                                                        <h4><?=$image['caption']?></h4>
                                                        <p>Caption...</p>
                                                        <input type="hidden" name="hidden-field" value="">
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
