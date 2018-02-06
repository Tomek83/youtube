<?php
namespace youtube\interfaces;

interface Dom
{
    function loadHtml($html);

    function getMeta();
}