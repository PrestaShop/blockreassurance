<div style="width:100%;text-align:center">
    {foreach from=$blocks item=$block key=$key}
        <div style="display:inline-block;width:360px;margin:0px auto;text-align:center;vertical-align:top;{if $block['type_link'] != 0 && $block['link'] != ''}cursor:pointer;{/if}" 
        {if $block['type_link'] != 0 && $block['link'] != ''} onclick="window.open('{$block['link']}')"{/if}>
            <span style="color:{$iconeColor};display:block;"><i class="material-icons psrea-color" style="font-size:60px">{$block['icone']}</i></span>
            <span style="color:{$textColor};diplay:block;font-weight:bold">{$block['title']}<span>
            <p style="color:{$textColor};">{$block['description']}</p>
        </div>
    {/foreach}
    <div class="clearfix"></div>
</div>