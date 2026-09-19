<div class="container-fluid mt-30">
    <input type="hidden" id="id" value="{{ $id }}">
<input type="hidden" id="key" value="{{ $key }}">
    <div class="row">
        <div class="col-lg-10 mb-20">
            <label> <strong>{{___('settings.shortcodes')}}</strong> </label>
            <span class="text-primary">
                {{ $shortcode }}
            </span>
        </div>
        <div class="col-lg-12">
            <div class="primary_input">

                <label class="primary_input_label" for="">{{___('settings.subject')}}</label>
                <input class="primary_input_field form-control" type="text" name="subject" id="subject"
                    value="{{ $subject }}">
                <div class="primary_input mt-20">
                    <label class="primary_input_label" for="">{{___('settings.email_description')}}</label>
                    <textarea class="primary_input_field summer_note form-control" id="email_body"
                        cols="0" rows="4" name="emailBody" >{{ $emailBody }}</textarea>
                </div>
                <div class="primary_input mt-20">
                    <label class="primary_input_label" for="">{{___('settings.sms_content')}}</label>
                    <textarea class="primary_input_field form-control" id="sms_body"
                        cols="0" rows="4" name="smsBody">{{ $smsBody }}</textarea>
                </div>
                <div class="primary_input mt-20">
                    <label class="primary_input_label d-flex" for="">{{___('settings.app_message')}}

                    </label>
                    <textarea class="primary_input_field form-control" id="app_body"
                        cols="0" rows="4" name="appBody">{{ $appBody }}</textarea>
                </div>
                <div class="primary_input mt-20">
                    <label class="primary_input_label d-flex" for="">{{___('settings.web_message')}}

                    </label>
                    <textarea class="primary_input_field form-control ot-form-control"
                        cols="0" rows="4" name="webBody" id="web_body">{{ $webBody }}</textarea>
                </div>
                <div class="row mt-40">
                    <div class="col-lg-12 text-center">
                        <button type="submit" class="btn btn-lg ot-btn-primary updateNotificationModal">

                            {{___('common.update')}}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        try {
            $('.summer_note').summernote({
                tabsize: 2,
                height: 400
            });
        } catch (e) {

        }
    });
</script>
