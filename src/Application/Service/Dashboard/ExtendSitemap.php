<?php
namespace Concrete\Package\SuitonBaseUtil\Src\Application\Service\Dashboard;
use Page;
class ExtendSitemap extends \Concrete\Core\Application\Service\Dashboard\Sitemap
{
    public function getNode($cItem, $includeChildren = true, $onGetNode = null)
    {
        $node = parent::getNode($cItem, $includeChildren, $onGetNode);
        $c = Page::getByID($node->cID, 'RECENT');
        $cv = $c->getVersionObject();
        if (!$c->isError()) {
            $inheritance = $c->getCollectionInheritance();
            if ($inheritance !== 'PARENT') {
                $node->title = $node->title . ' (' . $inheritance . ')';
            }

            if(!$cv->cvIsApproved){
                $node->title = $node->title . '　<span class="label label-info">未承認バージョンあり</span>';
            }
        }
        return $node;
    }
}
