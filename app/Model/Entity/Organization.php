<?php

namespace App\Model\Entity;

class Organization
{
    /**
     * ID da organização
     * @var int
     */
    public int $id = 1;

    /**
     * Nome da organização
     * @var string
     */
    public string $name = 'Jonathan';

    /**
     * Site da organização
     * @var string
     */
    public string $site = '#';

    /**
     * [public description]
     * @var string
     */
    public string $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum efficitur mi nibh.
     Proin finibus, orci non scelerisque consequat, diam augue aliquet quam, in consequat odio arcu eget massa. Vivamus
     fringilla lacus eget sem facilisis eleifend. Nulla rutrum feugiat ligula. Sed consequat porta varius. Vestibulum
     pharetra nibh eu elit posuere, id mattis massa scelerisque. In interdum vestibulum gravida. Mauris at semper turpis. 
     Etiam varius venenatis tellus eu pellentesque. Donec ac dapibus dolor. Proin nec facilisis nisl. Fusce pulvinar 
     purus eget est venenatis vulputate vel eu nisl. Nullam tempus malesuada placerat. Donec dignissim diam mauris, sed 
     tincidunt risus posuere in. Quisque ullamcorper suscipit massa. Pellentesque habitant morbi tristique senectus et 
     netus et malesuada fames ac turpis egestas. Integer non lectus eget eros bibendum laoreet nec nec ex. Aenean quis 
     nibh vitae erat tincidunt maximus. Donec consectetur tellus ac turpis sollicitudin, at accumsan lectus ornare. Sed 
     ut neque augue. Proin tempor erat consectetur turpis commodo convallis. In dictum blandit turpis, sed ultrices nunc 
     finibus ut. Aliquam ac velit justo. Maecenas sed sem vitae risus suscipit feugiat sit amet id erat. Maecenas egestas 
     elementum tortor, at aliquet justo interdum nec. Duis ac lectus rutrum, placerat lacus vitae, auctor justo. Sed 
     auctor hendrerit justo, ac imperdiet enim pretium et.';
}