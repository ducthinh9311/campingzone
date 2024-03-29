<script>
    $(document).on('click', '.delete', function () {
        let url = $(this).attr('data-url');
        let id = $(this).attr('data-message');
        $("#deleteForm").attr('action', url);
        $("#deleteMessage").html(`${id}`);
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable({
            "language": {
                "zeroRecords": "Không tìm thấy dữ liệu phù hợp",
                "emptyTable": "Không có dữ liệu",
                "search": "Tìm kiếm",
                "info": "Hiển thị từ _START_ đến _END_ trong _TOTAL_ kết quả",
                "infoEmpty": "Hiển thị 0 kết quả",
                "infoFiltered": "(Lọc từ _MAX_ kết quả)",
                "paginate": {"first": "Đầu", "last": "Cuối", "next": "Sau", "previous": "Trước"},
                "lengthMenu": "Hiện _MENU_ mục",
            },
            "ordering": false,
        });
    });
</script>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Buttons examples -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="assets\js\pages\datatables.init.js"></script>
