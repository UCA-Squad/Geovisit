<?php
/*
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

<div class="videoContainer">
    <video id='atelier-video' muted autofocus>
        <source src="{{ asset($site->video) }}">
    </video>
    <div class="control">
        <div class="topControl">
            <div class="progress">
                <span class="bufferBar"></span>
                <span class="timeBar"></span>
            </div>
            <div class="time">
                <span class="current"></span>&nbsp;/&nbsp;
                <span class="duration"></span>
            </div>
        </div>
        <div class="btmControl">
            <div class="btnPlay btn" title="Play/Pause video"></div>
            <div class="btnStop btn" title="Stop video"></div>
            <div class="spdText btn">Speed: </div>
            <div class="btnx025 btn text" title="Slow motion x0.25">x0.25</div>
            <div class="btnx05 btn text" title="Slow motion x0.5">x0.5</div>
            <div class="btnx1 btn text selected" title="Normal speed">x1</div>
            <div class="btnx125 btn text" title="Fast forward x1.25">x1.25</div>
            <div class="btnx15 btn text" title="Fast forward x1.5">x1.5</div>
            <div class="btnx2 btn text" title="Fast forward x2">x2</div>
        </div>
    </div>
</div>