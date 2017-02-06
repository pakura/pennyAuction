<div class="topPtion">
    <h2>Users List</h2>
</div>
<div style="font-family: Myup">
    <div id="auctionLIST">
        <table id="dataTable_0" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full name</th>
                <th>Gender</th>
                <th>Date of birth</th>
                <th>ID Number</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>Verified</th>
                <th>Open Profile</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full name</th>
                <th>Gender</th>
                <th>Date of birth</th>
                <th>ID Number</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>City</th>
                <th>Verified</th>
                <th>Open Profile</th>
            </tr>
            </tfoot>

            <tbody id="table_content">

            </tbody>
        </table>
    </div>
</div>
<div id="poster"></div>

<script>
    var tablecnt = 0;
    var tablehtml;
    $(document).ready(function() {
        tablehtml= $('#auctionLIST').html();
        $('#dataTable_0').DataTable({
            'iDisplayLength': 30,
            "order": [[ 0, "desc" ]]
        });
        getUsers();

    });
</script>