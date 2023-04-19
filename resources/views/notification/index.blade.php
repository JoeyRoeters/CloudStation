<x-auth-layout>
    <div class="row">
        <table id="datatable" class="table table-row-bordered">
            <thead>
            <tr class="fw-semibold fs-6 text-muted">
                <th>Station name</th>
                <th>Message</th>
                <th>Read</th>
            </tr>
            </thead>
            <tfoot>
            <tr class="fw-semibold fs-6 text-muted">
                <th>Station name</th>
                <th>Message</th>
                <th>Read</th>
            </tr>
            </tfoot>
        </table>
    </div>

    @push('footer')
        <script>
            $("#datatable").DataTable({
                processing: true,
                serverSide: true,
                ajax: '/notification/table',
                columnDefs: [
                    {
                        targets: -3,
                        render: function (data, type, row) {
                            return JSON.parse(row[0])['station']
                        }
                    },
                    {
                        targets: -2,
                        render: function (data, type, row) {
                            return 'No data received from this station the past hour.'
                        }
                    },
                    {
                        targets: -1,
                        render: function (data, type, row) {
                            return '<a href="/notification/' + JSON.parse(row[0])['station'] + '"><button class="btn-sm btn-light btn">Mark as read</button></a>';
                        }
                    },
                ],
            });
        </script>
    @endpush
</x-auth-layout>


