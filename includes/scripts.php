<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/dist/js/adminlte.min.js"></script>
<script src="../public/js/jq.schedule.min.js"></script>
<script src="../public/js/bootstrap-picker.js"></script>
<script src="../public/js/picker.js"></script>
<script src="../public/js/picker.time.js"></script>
<script src="../public/js/popModal.js"></script>
<script src="../public/js/jnoty.min.js"></script>
<script src="../public/js/colorPick.js"></script>
<script src="../public/js/script.js"></script>

<!-- <script src="../public/js/index.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

<script>
  $(function() {
    $.widget.bridge('uibutton', $.ui.button);

    /** add active class and stay opened when selected */
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
      return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
      return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

  });
</script>