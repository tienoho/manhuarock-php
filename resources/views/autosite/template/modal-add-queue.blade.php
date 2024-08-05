<div class="modal modal-blur fade modal-fullscreen" id="modal-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a new URL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-12">
                        <div id="from-source" class="form-group mb-3 row">
                            <label class="form-label col-12 col-form-label">From Source</label>
                            <select class="form-select" name="source" id="source">
                                @foreach((new CrawlHelpers())->scraplist() as $campaign)
                                    <option value="{{ $campaign }}">{{ $campaign }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="form-label col-12 col-form-label">URLS</label>
                            <textarea id="URLS" class="form-control" data-bs-toggle="autosize" placeholder="One URL per row"
                                      style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 156px;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add-queue">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#add-queue").click(function () {
       $.post(base_url + '/add-queue', {
           source: $("#source").val(),
           urls: $("#URLS").val().split("\n").map(element => element.trim())
       }).done(function (res) {
           console.log(res);
           if(res.status){
               location.reload();
           }
       })
    });
</script>