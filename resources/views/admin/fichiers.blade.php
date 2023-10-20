@extends('admin.layouts.base')

@section('content')
<div class="row-fluid" style="padding:0;">
    <div class="row" style="margin:20px;">
        <h1 class="etapes-titre">MES FICHIERS ({{ count($fichiers) }})</h1>
        @if(count($fichiers)!=0)
        <div class="table-responsive" style="width: 100%;">
            <table class="table table-striped table-bordered" style="width: 100%;" id="files_table">
                <thead>
                    <tr>
                        <th>NOM</th>
                        <th>DATE</th>
                        <th>TYPE</th>
                        <th>TAILLE</th>
                        <th>LIEN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fichiers as $file)
                    <tr>
                        <td>{{ $file['nom'] }}</td>
                        <td>{{ $file['date'] }}</td>
                        <td>{{ $file['type'] }}</td>
                        <td>{{ $file['size'] }}</td>
                        <td>{{ $file['url'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        @endif


    </div>

</div>
@endsection

@section('styles')
<style>
    th a{
        color: #f96332;}
    .lightboxcontainer {
        width:100%;
        text-align:left;
    }
    .lightboxleft {
        width: 40%;
        float:left;
    }
    .lightboxright {
        width: 60%;
        float:left;
    }
    .lightboxright iframe {
        min-height: 390px;
    }
    .divtext {
        margin: 36px;
    }
    .lightboxcontainer img{max-width:600px; max-height:500px; }
    .glyphicon-chevron-down, .glyphicon-chevron-up{font-size:12px}
    @media (max-width: 800px) {
        .lightboxleft {
            width: 100%;
        }
        .lightboxright {
            width: 100%;
        }
        .divtext {
            margin: 12px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#files_table").DataTable({
            columns: [
                null, 
                null,
                null,
                null,
                {render: function(data, type, row) {
                    return '<a href="'+data+'" target="_blank">' + data + '</a>';
                }}
            ]
        });
    });
</script>
@endsection