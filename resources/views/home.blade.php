@extends('layouts.app')

@section('content')
@vite('resources/sass/home.scss')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <div class="banner">
                        <img src="{{ Auth::user()->banner }}" alt="User Banner" class="img-fluid">
                    </div>
                    <div class="profile-pic">
                        <img src="{{ Auth::user()->profile_pic }}" alt="Profile Picture" class="rounded-circle">
                    </div>
                    <h2>{{ Auth::user()->name }}</h2>
                </div>


                <div class="card-body">
                    <h3>Update Profile</h3>
                    <form method="POST" action="{{ route('home.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password">Current Password (only if changing password)</label>
                            <input id="current_password" type="password" name="current_password">
                        </div>

                        <div>
                            <label for="new_password">New Password (only if changing password)</label>
                            <input id="new_password" type="password" name="new_password">
                        </div>

                        <div>
                            <label for="new_password_confirmation">Confirm New Password (only if changing password)</label>
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation">
                        </div>

                        <div>
                            <label for="profile_pic">Profile Picture</label>
                            <input id="profile_pic" type="file" name="profile_pic">
                        </div>

                        <div>
                            <label for="banner">Banner</label>
                            <input id="banner" type="file" name="banner">
                        </div>

                        <input type="hidden" id="cropped_profile_pic" name="cropped_profile_pic">
                        <input type="hidden" id="cropped_banner" name="cropped_banner">

                        <button type="submit">Update Profile</button>
                    </form>

                    <h3>Favorites</h3>
                    <div id="favorites">
                        <!-- Display the user's favorite movies, books, or games here -->
                    </div>

                    <h3>Review and Comment History</h3>
                    <div id="history">
                        <h4>Reviews</h4>
                        @foreach (Auth::user()->reviews as $review)
                            <div>
                                <h5>{{ $review->title }}</h5>
                                <p>{{ $review->content }}</p>
                            </div>
                        @endforeach

                        <h4>Responses</h4>
                        @foreach (Auth::user()->responses as $response)
                            <div>
                                <p>{{ $response->content }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add the cropping modal -->
<div class="modal fade" id="crop-modal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <img id="crop-image" src="" alt="Crop Image" style="max-width: 100%;">
          </div>
          <div class="modal-footer">
              
              <button type="button" class="btn btn-primary" id="crop-button">Crop</button>
          </div>
      </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
  window.onload = function() {
    const cropImage = document.getElementById('crop-image');
    const cropper = new Cropper(cropImage, {
        aspectRatio: 1, // Set the aspect ratio for the profile picture or banner
        viewMode: 1,
    });

    const profilePicInput = document.getElementById('profile_pic');
    const bannerInput = document.getElementById('banner');
    let activeInput = null;

    profilePicInput.addEventListener('change', (event) => {
        if (event.target.files && event.target.files[0]) {
            activeInput = profilePicInput;
            const reader = new FileReader();
            reader.onload = (e) => {
                cropImage.src = e.target.result;
                cropper.replace(e.target.result);
            };
            reader.readAsDataURL(event.target.files[0]);
            $('#crop-modal').modal('show');
        }
    });

    bannerInput.addEventListener('change', (event) => {
        if (event.target.files && event.target.files[0]) {
            activeInput = bannerInput;
            const reader = new FileReader();
            reader.onload = (e) => {
                cropImage.src = e.target.result;
                cropper.replace(e.target.result);
            };
            reader.readAsDataURL(event.target.files[0]);
            $('#crop-modal').modal('show');
        }
    });

    const cropButton = document.getElementById('crop-button');

    cropButton.addEventListener('click', () => {
        const croppedCanvas = cropper.getCroppedCanvas();
        croppedCanvas.toBlob((blob) => {
            const reader = new FileReader();
            reader.onloadend = () => {
                if (activeInput === profilePicInput) {
                    document.getElementById('cropped_profile_pic').value = reader.result;
                } else if (activeInput === bannerInput) {
                    document.getElementById('cropped_banner').value = reader.result;
                }
            };
            reader.readAsDataURL(blob);

            const file = new File([blob], 'cropped-image.png', { type: 'image/png' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            if (activeInput === profilePicInput) {
                profilePicInput.files = dataTransfer.files;
            } else if (activeInput === bannerInput) {
                bannerInput.files = dataTransfer.files;
            }

            $('#crop-modal').modal('hide');
        });
    });

    const cancelButton = document.querySelector('[data-dismiss="modal"]');

    if (cancelButton) {
      cancelButton.addEventListener('click', () => {
          $('#crop-modal').modal('hide');
      });
    }
  }
</script>
@endsection