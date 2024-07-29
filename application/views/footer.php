      <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/metisMenu.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/dataTables.responsive.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/raphael.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/morris-data.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
      <script type="text/javascript" src='<?php echo base_url(); ?>assets/tinymce/js/tinymce/tinymce.js'></script>
      <script>
        tinyMCE.init({
            theme : "modern",
            //mode : "textareas",
            mode : "specific_textareas",
            editor_selector : "page-textarea-admin",
            plugins : "image,imagetools,insertdatetime,preview,emoticons,visualchars,nonbreaking,code",
//            toolbar: "code",
//            menubar: "tools",
            theme_advanced_buttons1_add: 'insertimage,insertfile',
            theme_advanced_buttons2_add: 'separator,forecolor,backcolor',
            theme_advanced_buttons3_add: 'emotions,insertdate,inserttime,preview,visualchars,nonbreaking',
            theme_advanced_disable: "styleselect,formatselect,removeformat",
            plugin_insertdate_dateFormat : "%Y-%m-%d",
            plugin_insertdate_timeFormat : "%H:%M:%S",
            theme_advanced_toolbar_align : "left",
            theme_advanced_resize_horizontal : false,
            theme_advanced_resizing : true,
            apply_source_formatting : true,
            spellchecker_languages : "+English=en",
            extended_valid_elements :"img[src|border=0|alt|title|width|height|align|name],"
            +"a[href|target|name|title],"
            +"p,",
            invalid_elements: "table,span,tr,td,tbody,font"

        });
      </script>
      <script type="text/javascript">
        $(document).ready(function() {
          if ( $('#adminlocksmith-dataTables').length > 0 ){
            $('#adminlocksmith-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getlocksmith',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#admincustomer-dataTables').length > 0 ){
            $('#admincustomer-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getcustomer',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#adminbike-dataTables').length > 0 ){
            $('#adminbike-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getbike',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#adminprices-dataTables').length > 0 ){
            var url = window.location.href;
            var id = url.split("/prices/");
            $('#adminprices-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getprice/' + id[1],
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#adminorder-dataTables').length > 0 ){
            $('#adminorder-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getorders',
                "type": "POST",
                "columns": [
                  { "data" : "id" },
                  { "data" : "locksmith" },
                  { "data" : "customer" },
                  { "data" : "type" },
                  { "data" : "price" },
                  { "data" : "evening" },
                  { "data" : "weekend" },
                  { "data" : "start_date" }
                ]
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#adminreview-dataTables').length > 0 ){
            $('#adminreview-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getreviews',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#adminlocktransaction-dataTables').length > 0 ){
            $('#adminlocktransaction-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/gettransactions/1',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#admincusttransaction-dataTables').length > 0 ){
            $('#admincusttransaction-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/gettransactions/2',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#locksmithcustomer-dataTables').length > 0 ){
            $('#locksmithcustomer-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>locksmith/getcustomers',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#locksmithprice-dataTables').length > 0 ){
            $('#locksmithprice-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>locksmith/getprices',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }


          if ( $('#locksmithorder-dataTables').length > 0 ){
            $('#locksmithorder-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>locksmith/getorders',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#locksmithreview-dataTables').length > 0 ){
            $('#locksmithreview-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>locksmith/getreviews',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#locksmithmytransaction-dataTables').length > 0 ){
            $('#locksmithmytransaction-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>locksmith/gettransactions/1',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#locksmithcusttransaction-dataTables').length > 0 ){
            $('#locksmithcusttransaction-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>locksmith/gettransactions/2',
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }

          if ( $('#adminpage-dataTables').length > 0 ){
            $('#adminpage-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getpages',
                "type": "POST",
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false,
                },
              ],
            });
          }
          if ( $('#admincoupon-dataTables').length > 0 ){
            $('#admincoupon-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getcoupons',
                "type": "POST",
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false,
                },
              ],
            });
          }
          if ( $('#adminpromotion-dataTables').length > 0 ){
            $('#adminpromotion-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getpromotions',
                "type": "POST",
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false,
                },
              ],
            });
          }
          if ( $('#adminservice-dataTables').length > 0 ){
            $('#adminservice-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getservices',
                "type": "POST",
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false,
                },
              ],
            });
          }
          if ( $('#admincontent-dataTables').length > 0 ){
            var url = window.location.href;
            var id = url.split("/contents/");
            $('#admincontent-dataTables').DataTable({
              "processing": true,
              "serverSide": true,
              "order": [],
              ajax: {
                url: '<?php echo base_url(); ?>admin/getcontents/' + id[1],
                "type": "POST"
              },
              "columnDefs": [
                { 
                  "targets": [ 0 ],
                  "orderable": false
                }
              ]
            });
          }
        });
      </script>
    </div>
  </body>
</html>