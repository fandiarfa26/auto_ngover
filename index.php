<?php
    $categories = [
        ['id' => 1, 'title' => 'Pendidikan', 'color' => '#74b9ff'],
        ['id' => 2, 'title' => 'Sosial Budaya', 'color' => '#e17055'],
        ['id' => 3, 'title' => 'Bahasa', 'color' => '#fdcb6e'],
        ['id' => 4, 'title' => 'Teknologi', 'color' => '#0984e3'],
        ['id' => 5, 'title' => 'Ekonomi', 'color' => '#00cec9'],
        ['id' => 6, 'title' => 'Sejarah & Geografi', 'color' => '#6c5ce7'],
        ['id' => 7, 'title' => 'Psikologi', 'color' => '#fd79a8'],
        ['id' => 8, 'title' => 'Fisika Biologi', 'color' => '#55efc4'],
        ['id' => 9, 'title' => 'Olahraga', 'color' => '#d63031'],
        ['id' => 10, 'title' => 'Kesehatan', 'color' => '#81ecec'],
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Cover Book ~~</title>
    <link href="https://fonts.googleapis.com/css2?family=Overpass&family=Patua+One&display=swap" rel="stylesheet"> 
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        #preview-img {
            position: absolute;
            top:0;
        }
        .overlay-cover {
            position: absolute;
            top:0;
            width: 400px;
            height: 600px;
        }
        .img-no-cover {
            padding: 30px 10px;
            width: 400px;
            height: 600px;
            text-align: center;
            display: grid;
            grid-template-column: 1fr;
            grid-template-row: 2fr 1fr;
        }
        .img-no-cover h1,h3 {
            color:white;
        }

        .img-no-cover h1 {
            font-family: 'Patua One', cursive;
            align-self: center;
        }

        .img-no-cover h3 {
            font-family: 'Overpass', sans-serif;
            align-self: end;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="card mb-3" style="z-index: 10">
                    <div class="row no-gutters">
                        <div class="col-md-3">
                            <img id="img-preview" src="img/preview_cover.jpg" class="card-img" alt="preview cover">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">Bikin Cover Buku Otomatis</h5>
                                <form action="index.php" method="post">
                                    <div class="form-group">
                                        <label for="title">Judul</label>
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Kategori</label> 
                                        <select name="category" id="category" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <?php foreach ($categories as $cat) { ?>
                                                <option value="<?= $cat['id'] ?>" data-color="<?= $cat['color'] ?>"><?= $cat['title'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <small>*Warna cover sesuai kategori</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="author">Pengarang</label> 
                                        <input type="text" id="author" name="author" class="form-control">
                                    </div>
                                    <button type="button" id="submit-btn" class="btn btn-primary">Submit</button>
                                </form>
                                <!-- <p class="card-text"><small class="text-muted">Orientasi Gambar: Potrait</small></p> -->
                            </div>
                        </div>
                    </div>
                </div>

                

                <div id="preview-img">
                    <div class="overlay-cover bg-light"></div>
                    <div id="canvas-cover" class="img-no-cover" style="background-color: #eee">
                        <h1 id="cover-title">no title</h1>
                        <h3 id="cover-author">no author</h3>
                    </div>
                </div>

                <div id="alertsucc" class="alert alert-success" role="alert" style="display:none;">Berhasil</div>

            </div>
        </div>
    </div>

 
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        function createCover() {
            html2canvas($('#canvas-cover'), {
                onrendered: function(canvas) {
                    var cover_img = canvas.toDataURL('image/png');
                    $.ajax({
                        type: "POST",
                        url: "process.php",
                        data: { 
                            img: cover_img
                        },
                    }).done(function(o) {
                        $('#img-preview').attr('src', o);
                        $('#alertsucc').show();
                        clearForm();
                    });
                }
            });
            
        }

        function clearForm() {
            $('#title').val('');
            $('#category').val('');
            $('#author').val('');
        }

        $('#category').on('change', function() {
            let color = $(this).find(':selected').data('color');
            $('#canvas-cover').css("background-color", color);
        });
                    
        $('#submit-btn').on('click', function() {
            $('#cover-title').html($('#title').val());
            $('#cover-author').html($('#author').val());
            
            createCover();
        });
    </script>
</body>
</html>