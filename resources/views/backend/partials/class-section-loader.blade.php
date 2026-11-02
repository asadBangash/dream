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

    function fillSections($sectionSelect, rows, selectedSectionId) {
        if (!$sectionSelect.length) {
            return;
        }
        if (selectedSectionId === undefined || selectedSectionId === null || selectedSectionId === '') {
            selectedSectionId = $sectionSelect.data('initial-section') || $sectionSelect.val();
        }
        $sectionSelect.find('option:not(:first)').remove();
        $.each(rows || [], function (i, item) {
            var row = sectionLabel(item);
            if (!row.id) {
                return;
            }
            $sectionSelect.append($('<option></option>').val(row.id).text(row.label));
        });
        if (selectedSectionId && $sectionSelect.find('option[value="' + selectedSectionId + '"]').length) {
            $sectionSelect.val(String(selectedSectionId));
        }
        if (typeof $sectionSelect.niceSelect === 'function') {
            $sectionSelect.niceSelect('update');
        }
        var $dropdown = $sectionSelect.next('.nice-select');
        if ($dropdown.length) {
            var sectionLi = '';
            var selectedText = $sectionSelect.find('option:first').text();
            $sectionSelect.find('option').each(function () {
                var val = $(this).val();
                var text = $(this).text();
                var selectedClass = $sectionSelect.val() === val ? ' selected focus' : '';
                sectionLi += '<li data-value="' + val + '" class="option' + selectedClass + '">' + text + '</li>';
                if ($sectionSelect.val() === val) {
                    selectedText = text;
                }
            });
            $dropdown.find('.current').html(selectedText);
            $dropdown.find('.list li').remove();
            $dropdown.find('.list').append(sectionLi);
        }
    }

    function loadSectionsForForm($form, classId, preserveSelection) {
        var $sectionSelect = $form.find('select.sections').first();
        if (!$sectionSelect.length) {
            return;
        }
        var preserveSection = preserveSelection
            ? ($sectionSelect.data('initial-section') || $sectionSelect.val())
            : null;
        if (!classId) {
            fillSections($sectionSelect, [], preserveSection);
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
                fillSections($sectionSelect, rows, preserveSection);
            },
            error: function () {
                fillSections($sectionSelect, [], preserveSection);
            }
        });
    }

    $(document).on('change', 'form select[name="class"]', function () {
        if ($(this).hasClass('sections') || $(this).is('select[name="section"]')) {
            return;
        }
        loadSectionsForForm($(this).closest('form'), $(this).val(), false);
    });

    $(function () {
        $('form').has('select.sections').each(function () {
            var $form = $(this);
            var $class = $form.find('select[name="class"]').first();
            var $sectionSelect = $form.find('select.sections').first();
            if (!$class.val()) {
                return;
            }
            // Edit forms already render section options; reloading clears the selection.
            if ($sectionSelect.find('option').length > 1) {
                return;
            }
            loadSectionsForForm($form, $class.val(), true);
        });
    });
})();
</script>
@endpush
