$(document).ready(function () {
    $(document).on('click', '.toggle-description', function () {
        const $this = $(this);
        const $short = $this.siblings('.description-short');
        const $full = $this.siblings('.description-full');
        if ($full.hasClass('hidden')) {
            $full.removeClass('hidden');
            $short.addClass('hidden');
            $this.text('less');
        } else {
            $full.addClass('hidden');
            $short.removeClass('hidden');
            $this.text('more');
        }
    });
});

$(document).ready(function () {
    $('#image-upload').on('change', function (event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#view_area').html(`<img src="${e.target.result}" alt="Uploaded Image" class="max-w-full h-auto rounded-lg">`);
            }
            reader.readAsDataURL(file);
        } else {
            alert('Please upload a valid image file.');
        }
    });

    $('[data-modal-hide="default-modal"]').on('click', function () {
        $('#default-modal').addClass('hidden');
    });

    $('#open-modal-btn').on('click', function () {
        $('#default-modal').removeClass('hidden');
    });
});