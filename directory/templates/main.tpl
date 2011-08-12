{* Calculate title from path *}
{capture name="title"}
   {if count($path) > 1} - {/if}
   {foreach from=$path item=category name=path}
      {if $smarty.foreach.path.iteration gt 2}
         &gt;
      {/if}
      {if not $smarty.foreach.path.first}
         {$category.TITLE}
      {/if}
   {/foreach}
{/capture}

{strip}
{if $title_prefix}
   {assign var="in_page_title" value=$title_prefix|cat:$category.TITLE}
{else}
   {assign var="in_page_title" value=$category.TITLE}
{/if}
{assign var="description" value=$category.DESCRIPTION}

{include file="header.tpl"}

{include file="top_bar.tpl"}

{* Calculate the number of categories per row *}
{php}
   $this->assign('cats_per_col', ceil(count($this->get_template_vars('categs')) / CATS_PER_ROW));
{/php}

{if $cats_per_col > 15}
   {php}
      $this->assign('cats_per_col', ceil(count($this->get_template_vars('categs')) / (CATS_PER_ROW + 1)));
   {/php}
{/if}

{* Categories *}
{if !empty($categs)}
   <div class="categories">
      {if !empty($category.ID)}
         <h3>{l}Categories{/l}</h3>
      {/if}

      <table border="0" cellpadding="0" cellspacing="2">
      <tr>
         {foreach from=$categs item=cat name=categs}
         {if ($smarty.foreach.categs.iteration mod $cats_per_col eq 1 and $cats_per_col gt 1) or $smarty.foreach.categs.first}<td>{/if}
         <h2><a href="{if $smarty.const.ENABLE_REWRITE}{$cat.TITLE_URL|escape}/{else}index.php?c={$cat.ID}{/if}">{$cat.TITLE|escape}</a>{if $smarty.const.CATS_COUNT} <span class="count">({$cat.COUNT})</span>{/if}</h2>

         {* Display subcategories *}
         {if !empty($cat.SUBCATS)}
         <p class="subcats">
            {foreach from=$cat.SUBCATS item=scat name=scategs}
               <a href="{if $smarty.const.ENABLE_REWRITE}{$cat.TITLE_URL|escape}/{$scat.TITLE_URL|escape}/{else}index.php?c={$scat.ID}{/if}">
            {$scat.TITLE|escape}</a>, {/foreach} ...
         </p>
         {/if}
         {if ($smarty.foreach.categs.iteration mod $cats_per_col eq 0 and $cats_per_col gt 1) or $smarty.foreach.categs.last}</td>{/if}
         {/foreach}
      </tr>
      </table>
   </div>
{/if}

{if $smarty.const.FTR_ENABLE == 1 and isset($feat_links) and !empty($feat_links)}
   <div class="feat_links">
      <h3>{l}Featured Links{/l}</h3>
      {foreach from=$feat_links item=link name=links}
         {include file="link.tpl" link=$link}
      {/foreach}
   </div>
{/if}

{* Links heading and sorting*}
{if ($qu or $category.ID gt 0 or $p) and isset($links) and !empty($links)}
   <div id="links">
      <h3>{l}Links{/l} {if not $p}<span class="small" style="margin-left:50px;">{l}Sort by{/l}:
      {if $smarty.const.ENABLE_PAGERANK and $smarty.const.SHOW_PAGERANK}{if $sort eq 'P'}<span class="sort"> {l}PageRank{/l}</span>{else}<a href="?s=P{if not $smarty.const.ENABLE_REWRITE}&amp;c={$category.ID}{/if}{if $qu}&amp;q={$qu}{/if}{if !empty($p)}&amp;p={$p}{/if}"> {l}PageRank{/l}</a>{/if} |{/if}
      {if $sort eq 'H'} <span class="sort">{l}Hits{/l}</span>{else} <a href="?s=H{if not $smarty.const.ENABLE_REWRITE}&amp;c={$category.ID}{/if}{if $qu}&amp;q={$qu}{/if}{if !empty($p)}&amp;p={$p}{/if}">{l}Hits{/l}</a>{/if}
      {if $sort eq 'A'} | <span class="sort">{l}Alphabetical{/l}</span>{else} | <a href="?s=A{if not $smarty.const.ENABLE_REWRITE}&amp;c={$category.ID}{/if}{if $qu}&amp;q={$qu}{/if}{if !empty($p)}&amp;p={$p}{/if}">{l}Alphabetical{/l}</a>{/if}
      </span>{/if}</h3>

      {foreach from=$links item=link name=links}
         {include file="link.tpl" link=$link}
      {/foreach}
   </div>
{/if}

{* Javascript for tracking link clicks *}
<script type="text/javascript">
/* <![CDATA[ */
   var root = '{$smarty.const.DOC_ROOT}';
   {literal}
   var a = document.getElementsByTagName("a");
   for(i = 0; i< a.length; i++)
      if(a[i].id != '')
         a[i].onclick = count_link;
   function count_link() {
      i = new Image();
      i.src= root+'/cl.php?id='+this.id;
      return true;
   }
   {/literal}
/* ]]> */
</script>

{include file="footer.tpl"}
{/strip}