<?php
    date_default_timezone_set('Asia/Tbilisi');
    $from = date('Y-m-01 00:00');
    $to = date('Y-m-d H:i');
?>
<div class="topPtion">
    <div class="filter">
        Filter:
        <input type="checkbox" id="check1"/>
        <label for="check1">Show Finished</label>
    </div>

    <div class="dateFilter">
        <label for="from">Date From</label>
        <input class="inputs" style="width: 150px" type="datetime" id="from" value="<?= $from ?>">
        <label for="from">Date To</label>
        <input class="inputs" style="width: 150px" type="datetime" id="to" value="<?= $to ?>">
    </div>
    <div class="filterBTN">
        <button onclick="getAuctions()">Show</button>
    </div>
</div>
<div style="font-family: Myup">
    <div id="auctionLIST">
        <table id="dataTable_0" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Start time</th>
                <th>End time</th>
                <th>Bid price</th>
                <th>Buy Now</th>
                <th>Last bidder</th>
                <th>Price</th>
                <th>Payed</th>
                <th>Members</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Start time</th>
                <th>End time</th>
                <th>Bid price</th>
                <th>Buy Now</th>
                <th>Last bidder</th>
                <th>Price</th>
                <th>Payed</th>
                <th>Members</th>
            </tr>
            </tfoot>

            <tbody id="table_content">

            </tbody>
        </table>
    </div>
</div>
<div id="poster"></div>
<div class="popupBG" onclick="closePopup()"></div>
<div class="popup">
    <div class="top">
        Members Stats
        <div class="close hvr-grow" onclick="closePopup()"></div>
    </div>
    <div class="popupCont">
        <div id="membersLIST">
            <table id="dataTablem_0" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Total Bids</th>
                    <th>Autobid</th>
                    <th>Limit</th>
                    <th>Left</th>
                    <th>From</th>
                    <th>to</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <th>Username</th>
                    <th>Total Bids</th>
                    <th>Autobid</th>
                    <th>Limit</th>
                    <th>Left</th>
                    <th>From</th>
                    <th>to</th>
                </tr>
                </tfoot>

                <tbody id="table_contentm">

                </tbody>
            </table>
        </div>
    </div>
    <div class="popupFooter"></div>
</div>
<script>
    var tablecnt = 0;
    var tablecntM = 0;
    var tablehtmlM;
    var tablehtml;
    $(document).ready(function() {
        $('.inputs').datetimepicker({format:'Y-m-d H:i'});
        tablehtml= $('#auctionLIST').html();
        tablehtmlM = $('#membersLIST').html();
        $('#dataTablem_0').DataTable({
            'iDisplayLength': 10,
            "order": [[ 2, "desc" ]]
        });
        $('#dataTable_0').DataTable({
            'iDisplayLength': 30,
            "order": [[ 0, "desc" ]]
        });
        getAuctions();
        $('.titleM').click(function(){
            $('#poster').fadeOut();
        });
    });
</script>