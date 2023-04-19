<x-auth-layout>
        <table id="datatable" class="table table-row-bordered">
            <thead>
                <tr class="fw-semibold fs-6 text-muted">
                    <th>id</th>
                    <th>Name</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tfoot>
                <tr class="fw-semibold fs-6 text-muted">
                    <th>id</th>
                    <th>Name</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Detail</th>
                </tr>
            </tfoot>
        </table>

    @push('footer')
        <script>
            $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                ajax: '/station/table',
                language: {
                    lengthMenu: "Show _MENU_",
                },
                columnDefs: [
                    {  targets: -1,
                        render: function (data, type, row) {
                            return '<a href="/station/' + row[0] + '"><button class="btn-sm btn-light btn">View</button></a>';
                        }

                    }
                ],
                dom:
                    "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">"
            });
        </script>
    @endpush
</x-auth-layout>


