<?php
$type_of_task = [
    'Auto Manga', 'Auto Sitemap', 'Clear Cache'
];

$timeCRON = [
    '*/1 * * * *' => 'every 1 minute',
    '*/5 * * * *' => 'every 5 minute',
    '*/15 * * * *' => 'every 15 minute',
    '*/30 * * * *' => 'every 30 minute',
    '* */1 * * *' => 'every 1 hour',
    '* */2 * * *' => 'every 2 hour',
    '* */3 * * *' => 'every 3 hour',
    '* */6 * * *' => 'every 6 hour',
    '* */12 * * *' => 'every 12 hour',
];

?>
<!-- Add New Campaign -->
<div class="modal modal-blur fade modal-fullscreen" id="modal-ajax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add a new cron</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-12">
                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Type of Task</label>
                            <div class="col">
                                <select class="form-select" id="select-task" name="task">
                                    <option selected disabled>Chose type of Task</option>

                                    @foreach($type_of_task as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div style="display: none" id="from-source" class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">From Source</label>
                            <div class="col">
                                <select class="form-select" name="campaign" id="select-task">
                                    @foreach((new CrawlHelpers())->scraplist() as $campaign)
                                        <option value="{{ $campaign }}">{{ $campaign }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Execution cycle</label>
                            <div class="col">
                                <select class="form-select" name="time">
                                    @foreach($timeCRON as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add-cron">Add Cron</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var $modal_ajax = $("#modal-ajax");
    var $modal_content = $modal_ajax.find(".modal-content");

    var $before_notif = $modal_content.html();


    $("#select-task").change(function () {
        var optionSelected = $(this).find("option:selected");
        var task = optionSelected.val();

        $(this).val(task);

        console.log(task);

        switch (task) {
            case 'Auto Manga':
                $("#from-source").attr('style', '')
                break;

            default:
                $("#from-source").hide();
        }


    });

    $("#add-cron").click(function () {
        var $form = $modal_content.find("form")
        var data = $form.serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        console.log(data)
        $.post(base_url + '/add-cron', data).done(function (res) {
            console.log(res);
            if(res.status){
                alert("Added successful!");
            } else {
                alert(res.msg)
            }
        })

    });
</script>