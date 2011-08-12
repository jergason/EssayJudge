{capture name="title"} - {l}Submit Link{/l}{/capture}
{capture assign="in_page_title"}{l}Submit Link{/l}{/capture}
{capture assign="description"}{l}Submit a new link to the directory{/l}{/capture}

{include file="header.tpl"}
{include file="top_bar.tpl"}

{strip}

<form method="post" action="">
<table border="0" class="formPage">

{if $error}
   <tr><td colspan="2" class="err">
      {l}An error occured while saving the link.{/l}
      {if !empty($sqlError)}
         <p>{$sqlError}</p>
      {/if}
   </td></tr>
{/if}

{if $posted}
   <tr><td colspan="2" class="msg">
   {l}Link submitted and awaiting approval.{/l}<br />
   {l}Submit another link.{/l}
   </td></tr>
{/if}

{if count($price) gt 0}
	<tr><td colspan="2" class="price">
	<strong>{l}Pricing{/l}:</strong><br />
	<table border="0" cellspacing="0" cellpadding="0">
	{if $price.featured}
		<tr><td><input type="radio" name="LINK_TYPE" value="featured"{if $LINK_TYPE eq 'featured'} checked="true"{/if} />{l}Featured links{/l}</td><td>${$price.featured}</td></tr>
	{/if}
	{if $price.normal gt 0}
		<tr><td><input type="radio" name="LINK_TYPE" value="normal"{if $LINK_TYPE eq 'normal'} checked="true"{/if} />{l}Regular links{/l}</td><td>${$price.normal}</td></tr>
	{elseif $price.normal eq 0}
		<tr><td><input type="radio" name="LINK_TYPE" value="normal"{if $LINK_TYPE eq 'normal'} checked="true"{/if} />{l}Regular links{/l}</td><td>{l}free{/l}</td></tr>
	{/if}
	{if $price.reciprocal gt 0}
		<tr><td><input type="radio" name="LINK_TYPE" value="reciprocal"{if $LINK_TYPE eq 'reciprocal'} checked="true"{/if} />{l}Regular links with reciprocal{/l}</td><td>${$price.reciprocal}</td></tr>
	{elseif $price.reciprocal eq 0}
		<tr><td><input type="radio" name="LINK_TYPE" value="reciprocal"{if $LINK_TYPE eq 'reciprocal'} checked="true"{/if} />{l}Regular links with reciprocal{/l}</td><td>{l}free{/l}</td></tr>
	{/if}
	{if isset($price.free)}
		<tr><td><input type="radio" name="LINK_TYPE" value="free"{if $LINK_TYPE eq 'free'} checked="true"{/if} />{l}Links with nofollow attribute{/l}</td><td>free</td></tr>
	{/if}
	</table>
	{validate form="submit_link" id="v_LINK_TYPE" message=$smarty.capture.field_link_type}
	</td></tr>
{/if}
   <tr>
      <td class="label"><span class='req'>*</span>{l}Title{/l}:</td>
      <td class="field">
         <input type="text" name="TITLE" value="{$TITLE|escape|trim}" size="40" maxlength="255" class="text" />
         {validate form="submit_link" id="v_TITLE" message=$smarty.capture.field_char_required}
         {validate form="submit_link" id="v_TITLE_U" message=$smarty.capture.title_not_unique}
      </td>
   </tr>
   <tr>
      <td class="label"><span class='req'>*</span>{l}URL{/l}:</td>
      <td class="field">
         <input type="text" name="URL" value="{$URL|escape|trim}" size="40" maxlength="255" class="text"/>
         {validate form="submit_link" id="v_URL" message=$smarty.capture.invalid_url}
         {validate form="submit_link" id="v_URL_ONLINE" message=$smarty.capture.url_not_online}
         {validate form="submit_link" id="v_URL_U" message=$smarty.capture.url_not_unique}
      </td>
   </tr>
   <tr>
      <td class="label">{l}Description{/l}:</td>
      <td class="field">
         <textarea name="DESCRIPTION" rows="3" cols="37" class="text">{$DESCRIPTION|escape|trim}</textarea>
      </td>
   </tr>
   <tr>
      <td class="label"><span class='req'>*</span>{l}Your Name{/l}:</td>
      <td class="field">
         <input type="text" name="OWNER_NAME" value="{$OWNER_NAME|escape|trim}" size="40" maxlength="255" class="text" />
         {validate form="submit_link" id="v_OWNER_NAME" message=$smarty.capture.field_char_required}
      </td>
   </tr>
   <tr>
      <td class="label"><span class='req'>*</span>{l}Your Email{/l}:</td>
      <td class="field">
         <input type="text" name="OWNER_EMAIL" value="{$OWNER_EMAIL|escape|trim}" size="40" maxlength="255" class="text" />
         {validate form="submit_link" id="v_OWNER_EMAIL" message=$smarty.capture.invalid_email}
      </td>
   </tr>
   <tr>
   <td class="label"><span class='req'>*</span>{l}Category{/l}:</td>
      <td class="field">
         {html_options options=$categs selected=$CATEGORY_ID name="CATEGORY_ID"}
         {validate form="submit_link" id="v_CATEGORY_ID" message=$smarty.capture.no_url_in_top}
      </td>
   </tr>
   <tr>
      <td class="label">{if $recpr_required}<span class='req'>*</span>{/if}{l}Reciprocal Link URL{/l}:</td>
      <td class="field">
         <input type="text" name="RECPR_URL" value="{$RECPR_URL|escape|trim}" size="40" maxlength="255" class="text" />
         {validate form="submit_link" id="v_RECPR_URL" message=$smarty.capture.invalid_url}
         {validate form="submit_link" id="v_RECPR_ONLINE" message=$smarty.capture.url_not_online}
         {validate form="submit_link" id="v_RECPR_LINK" message=$smarty.capture.recpr_not_found|replace:'#SITE_URL#':$smarty.const.SITE_URL}
         <br />
         <p class="small">{l}To validate the reciprocal link please include the<br />following HTML code in the page at the URL<br />specified above, before submiting this form:{/l}</p>
         <textarea name="RECPR_TEXT" rows="2" readonly="readonly" cols="37" class="text">&lt;a href="{$smarty.const.SITE_URL}"&gt;{$smarty.const.SITE_NAME}&lt;/a&gt;</textarea>
      </td>
   </tr>

   {if $smarty.const.VISUAL_CONFIRM}
   <tr>
      <td class="label"><span class='req'>*</span>{l}Enter the code shown{/l}:</td>
         <td class="field">
            <input type="text" name="CAPTCHA" value="" size="10" maxlength="5" class="text" />
            {validate form="submit_link" id="v_CAPTCHA" message=$smarty.capture.invalid_code}<br />
            <p class="small">{l}This helps prevent automated registrations.{/l}</p>
            <img src="{$smarty.const.DOC_ROOT}/captcha.php" class="captcha" alt="{l}Visual Confirmation Security Code{/l}" title="{l}Visual Confirmation Security Code{/l}" />
         </td>
   </tr>
   {/if}

   <tr>
      <td colspan="2" class="buttons"><input type="submit" name="submit" value="{l}Continue{/l}" class="btn" /></td>
   </tr>
</table>
</form>
{include file="footer.tpl"}
{/strip}