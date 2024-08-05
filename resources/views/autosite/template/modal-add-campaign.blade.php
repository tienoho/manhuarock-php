<!-- Add New Campaign -->
<div class="modal modal-blur fade pr-0" id="modal-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a new campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <label class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name"/>
                    </div>
                </div>
                <div>
                    <label class="form-label">Campaign Code</label>
                    <textarea class="form-control" id="content" rows="10" name="content"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add-campaign">Add Campaign</button>
            </div>
        </div>
    </div>
</div>

<div id="success-body" class="d-none">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <div class="modal-status bg-success"></div>
    <div class="modal-body text-center py-4">
        <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <circle cx="12" cy="12" r="9"/>
            <path d="M9 12l2 2l4 -4"/>
        </svg>
        <h3>Add succedeed</h3>
        <div class="text-muted">Your payment of $290 has been successfully submitted. Your invoice has been sent to
            support@tabler.io.
        </div>
    </div>
    <div class="modal-footer">
        <div class="w-100">
            <div class="row">
                <div class="col">
                    <a href="#" class="btn w-100" data-bs-dismiss="modal">
                        Go to dashboard
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="btn btn-success w-100" data-bs-dismiss="modal">
                        View campaign
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var $modal_ajax = $("#modal-ajax");
    var $modal_content = $modal_ajax.find(".modal-content");

    var $before_notif = $modal_content.html();

    $("#add-campaign").click(function () {

        let data = {
            name: $modal_ajax.find("#name").val(),
            content: $modal_ajax.find("#content").val(),
        };

        $.post(base_url + '/add-campaign', data).done(function (res) {
            if (res.status) {
                $modal_content.html($("#success-body").html());
            } else {
                alert(res.mgs ?? res);
            }
        })

    });
</script>