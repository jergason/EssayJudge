{strip}
<table><tr>
{* show page rank *}
{if $smarty.const.SHOW_PAGERANK}
   <td>
      {include file="pagerank.tpl" pr=$link.PAGERANK}
   </td>
{/if}

<td>
   <a id="id_{$link.ID}" href="{$link.URL|escape|trim}" title="{$link.TITLE|escape|trim}"
      {* nofollow *}
      {if $link.NOFOLLOW or ($link.RECPR_VALID eq 0 and ($smarty.const.RECPR_NOFOLLOW eq 2 or ($smarty.const.RECPR_NOFOLLOW eq 1 and $link.RECPR_REQUIRED eq 1)))} rel="nofollow"{/if}
      {if $smarty.const.ENABLE_BLANK} target="_blank"{/if}>
      {$link.TITLE|escape|trim}</a> <span class="url">- {$link.URL|escape|trim}</span>

      <p>{$link.DESCRIPTION|escape|trim}</p>
</td>
</tr></table>
{/strip}