<?php /* Template name: our story */ ?>

<?php get_header(); ?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container" style="margin-bottom:40px;margin-top:20px;">
    <div class="col-md-12">
        <h1 class="underline" style="text-align:center;color:#011267;">Our Story</h1> 

        
    </div>
    
</div>
<div class="container">
    	<?php
echo do_shortcode('[timeline_wp id="366"]');
?>

    
</div>
<br><br>
<?php get_footer(); ?>