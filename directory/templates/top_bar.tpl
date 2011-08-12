{strip}
<div id="path">
   <div class="submit">
      {* Right(!!) part of the top bar *}

      {* Submit Link *}
      <a href="{$smarty.const.DOC_ROOT}/submit.php{if !empty ($category.ID) and $category.ID > 0}?c={$category.ID}{/if}" title="{l}Submit your link to the directory{/l}">{l}Submit Link{/l}</a>
      &nbsp;|&nbsp;
      <a href="{$smarty.const.DOC_ROOT}/index.php?p=d" title="{l}Browse latest submitted links{/l}">{l}Latest Links{/l}</a>
      &nbsp;|&nbsp;
      <a href="{$smarty.const.DOC_ROOT}/index.php?p=h" title="{l}Browse most popular links{/l}">{l}Top Hits{/l}</a>

      {* RSS feed icon *}
      {if $smarty.const.ENABLE_RSS and (!empty($qu) or !empty($category.ID) or $p)}
      &nbsp;|&nbsp;
         <a href="{$smarty.const.DOC_ROOT}/rss.php?{if !empty($qu)}q={$qu|@urlencode}{elseif $p}p={$p}{else}c={$category.ID}{/if}">
            <img src="{$smarty.const.DOC_ROOT}/images/xml.gif" align="top" alt="RSS Feed" border="0" />
         </a>
      {/if}

      {* Search form *}
      &nbsp;&nbsp;
      <form action="{$smarty.const.DOC_ROOT}/index.php" method="get">
         <input type="text" name="q" size="20" class="text" value="{if !empty($qu)}{$qu|escape}{/if}" /> <input type="submit" value="{l}Search{/l}" class="btn" />
      </form>
</div>

   {* Left(!!) part of the top bar *}

   {* Display current path *}
   {assign var="current_path" value=""}
   {foreach from=$path item=cat name=path}
      {assign var="current_path" value="`$current_path``$cat.TITLE_URL`/"}
      {if !$smarty.foreach.path.first} &raquo; {/if}
      {if !$smarty.foreach.path.last}
         <a href="{if $smarty.const.ENABLE_REWRITE}{$current_path}{else}index.php?c={$cat.ID}{/if}">{$cat.TITLE|escape|trim}</a>
      {else}
         {$cat.TITLE|escape|trim}
      {/if}
   {/foreach}
</div>
{/strip}