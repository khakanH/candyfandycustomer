<div id="LoadingModal" class="modal" data-backdrop="false" data-keyboard="true" style="height: 100%; background: rgba(0,0,0,0.6);">
          <center><img id="loading_gif" style="margin-top: 250px;" width="70" height="70" src="<?php echo config('app.img_url') ?>gif_candy.png"></center>
</div>





<!-- Order Detail Modal -->
<!-- ------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------ -->


<div id="OrderDetailModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true" aria-hidden="true" style="color: black;">
    <div class="modal-dialog modal-lg" id="OrderDetailModalDialog">
        <div class="modal-content" id="OrderDetailModalContent">
         
                  <div class="modal-header">
                      <h3 class="modal-title" id="OrderDetailModalLabel"></h3>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                      <div class="" id="OrderDetailModalData">

                                
                      </div>
              

                      </div>
                  <div class="modal-footer" id="OrderDetailModalFooter">
                      <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                      

                  </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------------------ -->




<script type="text/javascript">
	$(function() {
    var loading = $('#loading_gif'),
        degree = 360,
        timer;
    
    function rotate() {    
        loading.css({ transform: 'rotate(' + degree + 'deg)'});
        timer = setTimeout(function() {
            --degree;
            rotate();
        },5); //lower this to increase speed
    }
    
    rotate();
});
</script>