<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

/**
 * @category  Shopware
 * @package   Shopware\Tests
 * @copyright Copyright (c) 2012, shopware AG (http://www.shopware.de)
 */
class Shopware_Tests_Models_Category_BlogCategoryTreeListQueryTest extends Enlight_Components_Test_TestCase
{
    /**
     * @var \Shopware\Models\Category\Repository
     */
    protected $repo = null;

    protected $expected = array(
        1 => array(
            0 => array(
                'id' => 3,
                'name' => 'Deutsch',
                'position' => 0,
                'blog' => false,
                'childrenCount' => '1',
                'emotions' => null,
                'articles' => null,
            ),
            1 => array(
                'id' => 39,
                'name' => 'English',
                'position' => 1,
                'blog' => false,
                'childrenCount' => '1',
                'emotions' => null,
                'articles' => null,
            ),
        ),
        3 => array(
            0 => array(
                'id' => 17,
                'name' => 'Trends + News',
                'position' => 5,
                'blog' => true,
                'childrenCount' => '0',
                'emotions' => null,
                'articles' => null,
            ),
        ),
        39 => array(
            0 => array(
                'id' => 42,
                'name' => 'Trends + News',
                'position' => 0,
                'blog' => true,
                'childrenCount' => '0',
                'emotions' => null,
                'articles' => null,
            ),
        )
    );

    /**
     * @return Shopware\Models\Category\Repository
     */
    protected function getRepo() {
        if ($this->repo === null) {
            $this->repo = Shopware()->Models()->Category();
        }
        return $this->repo;
    }

    public function testQuery() {
        foreach($this->expected as $id => $expected) {
            $filter = array(array('property' => 'c.parentId', 'value' => $id));
            $query = $this->getRepo()->getBlogCategoryTreeListQuery($filter, array());
            $data = $this->removeDates($query->getArrayResult());
            $this->assertEquals($data, $expected);
        }
    }

    protected function removeDates($data) {
        foreach($data as &$subCategory) {
            unset($subCategory['changed']);
            unset($subCategory['cmsText']);
            unset($subCategory['added']);
            foreach($subCategory['emotions'] as &$emotion) {
                unset($emotion['createDate']);
                unset($emotion['modified']);
            }
            foreach($subCategory['articles'] as &$article) {
                unset($article['added']);
                unset($article['changed']);
                unset($article['mainDetail']['releaseDate']);
            }
        }
        return $data;
    }

}