<?php

/* 
 * This file is a part of the OPGC Data Center project
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */

?>

@extends('admin.layouts.base')

@section('filescripts')
<link rel="stylesheet" href="{{URL::asset('css/admin_sites.css') }}">
@endsection


@section('content')
<pre>
    <?php print_r($inputs); ?>
</pre>
@endsection