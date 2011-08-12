{strip}

{* Pager (not used yet) *}
{if $list_total gt 0}
   <div class="navig">
      <div style="float: right">

         {if $smarty.const.ENABLE_REWRITE}
            {assign var='url_pattern' value='?p=$'}
         {/if}

         {pager rowcount=$list_total limit=$smarty.const.PAGER_LPP class_num="" class_numon="a" class_text="" posvar="p" show="page" txt_next="Next" txt_prev="Previous" shift="1" separator=" " wrap_numon="[|]" url_pattern="$url_pattern"}

      </div>
      {l}Total records:{/l} {$list_total}
   </div>
{/if}

<div class="footer"><a href="http://www.phplinkdirectory.com" title="Powered by: php Link Directory">php Link Directory</a></div>
</body>
</html>
{/strip}