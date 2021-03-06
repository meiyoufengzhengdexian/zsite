{$templateName = CHANZHI_TEMPLATE}
{$themeName    = CHANZHI_THEME}
{$topNavs = $model->loadModel('nav')->getNavs('mobile_top')}
<header class='appbar fix-top' id='appbar'>
  <div class='appbar-title'>
    <a href='{$model->config->webRoot}' id='logo'>
      {$logoSetting = isset($model->config->site->logo) ? json_decode($model->config->site->logo) : new stdclass()}
      {$logo = false}
      {if(isset($logoSetting->$templateName->themes->all))}        {$logo = $logoSetting->$templateName->themes->all} {/if}
      {if(isset($logoSetting->$templateName->themes->$themeName))} {$logo = $logoSetting->$templateName->themes->$themeName} {/if}
      {if($logo)}
        {$logo->extension = $model->loadModel('file')->getExtension($logo->pathname)}
        {!html::image($model->loadModel('file')->printFileURL($logo->pathname, $logo->extension), "class='logo' alt='{{$model->config->company->name}}' title='{{$model->config->company->name}}'")}
      {else}
       <h4>{$model->config->site->name}</h4>
      {/if}
    </a>
  </div>
  <div class='appbar-actions'>
    {if(commonModel::isAvailable('search'))}
      <div class='dropdown'>
        <button type='button' class='btn' data-toggle='dropdown' id='searchToggle'><i class='icon-search'></i></button>
        <div class='dropdown-menu fade search-bar' id='searchbar'>
          <form action='{!helper::createLink('search')}' method='get' role='search'>
            <div class='input-group'>
              {$keywords = ($model->app->getModuleName() == 'search') ? $model->session->serachIngWord : ''}
              {!html::input('words', $keywords, "class='form-model' placeholder=''")}
              {if($model->config->requestType == 'GET')} {!html::hidden($model->config->moduleVar, 'search') . html::hidden($model->config->methodVar, 'index')} {/if}
                <div class='input-group-btn'>
                  <button class='btn default' type='submit'><i class='icon icon-search'></i></button>
                </div>
            </div>
          </form>
        </div>
      </div>
    {/if}
    {if(commonModel::isAvailable('shop'))}
      <a class='btn with-badge' href='{!helper::createLink('cart', 'browse')}'><i class='icon icon-shopping-cart'></i><strong class='cart-count badge small text-danger circle hide'>12</strong></a>
    {/if}
    {$isMultiLangAvailable = count(explode(',', $model->config->enabledLangs)) > 1}
    {$isUserAvailable = commonModel::isAvailable('user')}
    {if($isUserAvailable || $isMultiLangAvailable)}
      <div class='dropdown'>
        <button type='button' class='btn' data-toggle='dropdown'><i class='icon-bars circle'></i></button>
        <ul class='dropdown-menu dropdown-menu-right' id='topbarBox'>{$model->config->siteNavHolder}</ul>
      </div>
    {/if}
  </div>
</header>

<nav class='appnav fix-top appnav-auto' id='appnav' data-ve='navbar' data-type='mobile_top'>
  <div class='mainnav'>
    <ul class='nav'>
    {$subnavs = ''}
    {$navID   = 0}
    {foreach($topNavs as $nav1)}
      {@$navID++}
      <li class='{$nav1->class}'>
      {if(empty($nav1->children))}
        {!html::a($nav1->url, $nav1->title, ($nav1->target != 'modal') ? "target='$nav1->target'" : "data-toggle='modal'")}
      {else}
        {!html::a("#sub-{{$navID}}", $nav1->title . " <i class='icon-caret-down'></i>", ($nav1->target != 'modal') ? "target='$nav1->target'" : "data-toggle='modal'")}
        {$subnavs .= "<ul class='nav' id='sub-{{$navID}}'>\n"}
        {foreach($nav1->children as $nav2)}
          {$subnavs .= "<li class='{{$nav2->class}}'>"}
          {if(empty($nav2->children))}
            {$subnavs .= html::a($nav2->url, $nav2->title, ($nav2->target != 'modal') ? "target='$nav2->target'" : "data-toggle='modal' class='text-important'")}
          {else}
            {$subnavs .= html::a("javascript:;", $nav2->title . " <i class='icon-caret-down'></i>", "data-toggle='dropdown' class='text-important'")}
            {$subnavs .= "<ul class='dropdown-menu'>"}
            {foreach($nav2->children as $nav3)}
              {$subnavs .= "<li>" . html::a($nav3->url, $nav3->title, ($nav3->target != 'modal') ? "target='$nav3->target'" : "data-toggle='modal' class='text-important'") . '</li>'; }
            {/foreach}
            {$subnavs .= "</ul>\n"}
          {/if}
          {$subnavs .= "</li>\n"}
        {/foreach}
        {$subnavs .= "</ul>\n"}
      {/if}
      </li>
    {/foreach}<!-- end nav1 -->
    </ul>
  </div>
  <div class='subnavs fade'>
    {$subnavs}
  </div>
</nav>
