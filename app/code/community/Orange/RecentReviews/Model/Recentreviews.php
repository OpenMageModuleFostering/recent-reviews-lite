<?php
class Orange_RecentReviews_Model_RecentReviews extends Mage_Core_Model_Abstract
{
	public function getConfigData($item)
	{
		return Mage::getStoreConfig(sprintf('orange_recentreviews/settings/%s', $item));
	}
	public function isActive()
	{
		return $this->getConfigData('enable');
	}
	public function getTitle()
	{
		return $this->getConfigData('title');
	}
	public function showRatings()
	{
		return $this->getConfigData('show_ratings');
	}
	public function showTitle()
	{
		return $this->getConfigData('showtitle');
	}
	public function limitCharacters()
	{
		return $this->getConfigData('limit_characters');
	}
	public function getReviewUrl($id)
	{
		return Mage::getUrl('review/product/view', array('id'=> $id));
	}
    public function data()
    {
        if($this->getConfigData('count') < 1)
            $_limit = 0;
        else
            $_limit = $this->getConfigData('count');
        
        $_reviews = Mage::getModel('review/review')->getCollection()
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addStatusFilter('approved')
            ->setPageSize($_limit)
            ->setDateOrder()
            ->addRateVotes()
            ->load();
        return $_reviews;
    }
}
