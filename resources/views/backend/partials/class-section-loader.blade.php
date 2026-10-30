{{-- Loads sections when class changes; works even if cached custom.js is outdated on production. --}}
@push('script')
<script>
(function () {
    var sectionsUrl = @json(url('class-setup/get-sections'));

    function sectionLabel(item) {
        if (!item || !item.section) {
            return { id: null, label: '' };
        }
        var s = item.section;
        return { id: s.id, label: s.name || s.section_tran || s.sectionTran || '' };
    }

    function fillSections($sectionSelect, rows) {
        if (!$sectionSelect.length) {
            return;
        }
        $sectionSelect.find('option:not(:first)').remove();
        $.each(rows || [], function (i, item) {
            var row = sectionLabel(item);
            if (!row.id) {
                return;
            }
            $sectionSelect.append($('<option></option>').val(row.id).text(row.label));
        });
        if (typeof $sectionSelect.niceSelect === 'function') {
            $sectionSelect.niceSelect('update');
        }
        var $dropdown = $sectionSelect.next('.nice-select');
        if ($dropdown.length) {
            var sectionLi = '';
            $sectionSelect.find('option').each(function () {
                sectionLi += '<li data-value="' + $(this).val() + '" class="option">' + $(this).text() + '</li>';
            });
            $dropdown.find('.current').html($sectionSelect.find('option:first').text());
            $dropdown.find('.list li').remove();
            $dropdown.find('.list').append(sectionLi);
        }
    }

    function loadSectionsForForm($form, classId) {
        var $sectionSelect = $form.find('select.sections').first();
        if (!$sectionSelect.length) {
            return;
        }
        if (!classId) {
            fillSections($sectionSelect, []);
            return;
        }
        $.ajax({
            type: 'GET',
            dataType: 'json',
            data: { id: classId },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: sectionsUrl,
            success: function (data) {
                var rows = Array.isArray(data) ? data : (Array.isArray(data && data.data) ? data.data : []);
                fillSections($sectionSelect, rows);
            },
            error: function () {
                fillSections($sectionSelect, []);
            }
        });
    }

    $(document).on('change', 'form select[name="class"]', function () {
        if ($(this).hasClass('sections') || $(this).is('select[name="section"]')) {
            return;
        }
        loadSectionsForForm($(this).closest('form'), $(this).val());
    });

    $(function () {
        $('form').has('select.sections').each(function () {
            var $class = $(this).find('select[name="class"]').first();
            if ($class.val()) {
                loadSectionsForForm($(this), $class.val());
            }
        });
    });
})();
</script>
@endpush
