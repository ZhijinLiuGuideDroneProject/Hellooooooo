function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imagePreview').empty();
                $('#imagePreview').append('<img src="'+e.target.result+'" width=90px/>');

            };

            reader.readAsDataURL(input.files[0]);
        }
    }