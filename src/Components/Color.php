<?php
declare(strict_types=1);

namespace Palmaand\Shopware5BackupTool\Components;

/**
 * Class which also gives the possibility to color in messages.
 * For more information please visit: https://misc.flogisoft.com/bash/tip_colors_and_formatting.
 */
class Color
{

    public static $PREFIX = "\033[";
    public static $RESET = "0m";

    /** Textstyling */
    public static $BOLD = "1mBold";

    /** Colors */
    public static $RED = "101m";

    /**
     * Function used to color in the given string with the wanted color.
     *
     * @param string $message The message what will be colored in.
     * @param string $color The color in what the message will be shown.
     * @return string The customized message.
     * @throws conditon
     **/
    public function colorMessage(string $message, string $color, bool $bold = true)
    {
        if ($bold) {
            return $this->PREFIX . $this->BOLD . $color . $message . $this->PREFIX . $this->RESET;
        }
    }
}
