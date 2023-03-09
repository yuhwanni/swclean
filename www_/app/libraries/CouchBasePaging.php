<?php

class CouchBasePaging {
    /* 파라메타용 변수 */
    //protected $mBaseUrl;		//호출페이지
    protected $mCurPageNum;		//현제 페이지 번호
    protected $mPageVar;		//페이지에 사용되는 변수명
    protected $mExtraVar;		//추가 변수
    protected $mTotalItem;		//글갯수
    protected $mPerPage;		//출력 페이지수
    protected $mPerItem;		//출력 글 수
    protected $mPrevPage;		//[이전 페이지] text 또는 img tag
    protected $mNextPage;		//[다음 페이지] text 또는 img tag
    protected $mPrevPerPage;	//[이전 $mPerPage 페이지] text 또는 img tag
    protected $mNextPerPage;	//[다음 $mPerPage 페이지] text 또는 img tag
    protected $mFirstPage;		//[처음] 페이지 text 또는 img tag
    protected $mLastPage;		//[마지막] 페이지 text 또는 img tag
    protected $mPageCss;		//페이지 목록에 사용할 css
    protected $mCurPageCss;		//현재 페이지에 사용할 css

    /* 내부사용 변수 */
    protected $mPageCount;		//전체 페이지수
    protected $mTotalBlock;		//전체 블럭수
    protected $mBlock;			//현재 블럭수
    protected $mFirstPerPage;	//한블럭의 첫 페이지번호
    protected $mLastPerPage;	//한블럭의 마지막 페이지 번호
    protected static $instance; //singleton용 인스턴스 변수

    /**
     * 싱글톤용 인스턴스 리턴
     * @param array $params
     */
    public static function getInstance($params) {
        if(!isset(self::$instance)) {
            self::$instance = new self($params);
        }
        else {
            //이미 인스턴스가 생성되있을 경우 파라메터를 재적용(한페이지내에 다른 파라메타로 여려 페이징을 써야 할 경우)
            self::$instance->__construct($params);
        }

        return self::$instance;
    }

    /**
     * 생성자 - 온션을 성정하고 기본적인 페이지,블럭수 등을 계산
     * @param array $params
     */
    public function __construct($params) {
        if(!count($params)) {
            echo "[MongoPaging Error : 파라메터가 없습니다.]";
            return;
        }

        //$this->mBaseUrl = $params['curBaseUrl'] ? $params['curBaseUrl'] : $_SERVER['PHP_SELF'];
        $this->mCurPageNum = $params['curPageNum'] ? $params['curPageNum'] : 1;
        $this->mPageVar = $params['pageVar'] ? $params['pageVar'] : 'pagenum';
        $this->mExtraVar = $params['extraVar'] ? $params['extraVar'] : '';
        $this->mTotalItem = $params['totalItem'] ? $params['totalItem'] : 0;
        $this->mPerPage = $params['perPage'] ? $params['perPage'] : 10;
        $this->mPerItem = $params['perItem'] ? $params['perItem'] : 15;
        $this->mPrevPage = $params['prevPage'] ? $params['prevPage'] : '이전';
        $this->mNextPage = $params['nextPage'] ? $params['nextPage'] : '다음';
        $this->mPrevPerPage = $params['prevPerPage'];
        $this->mNextPerPage = $params['nextPerPage'];
        $this->mFirstPage = isset($params['firstPage']) ? $params['firstPage'] : "";
        $this->mLastPage = isset($params['lastPage']) ? $params['lastPage'] : "";
        $this->mPageCss = isset($params['pageCss']) ? $params['pageCss'] : "";
        $this->mCurPageCss = isset($params['curPageCss']) ? $params['curPageCss'] : "";

        $this->mPageCount = ceil($this->mTotalItem/$this->mPerItem);
        $this->mTotalBlock = ceil($this->mPageCount/$this->mPerPage);
        $this->mBlock = ceil($this->mCurPageNum/$this->mPerPage);
        $this->mFirstPerPage = ($this->mBlock-1)*$this->mPerPage;
        $this->mLastPerPage = $this->mTotalBlock<=$this->mBlock ? $this->mPageCount : $this->mBlock*$this->mPerPage;
    }

    /**
     * 현재 글번호를 리턴
     * @return integer
     */
    public function getItemNum() {
        return $this->mTotalItem-($this->mCurPageNum-1)*$this->mPerItem;
    }

    /**
     * 첫페이지 번호 링크를 리턴
     * @return string
     */
    public function getFirstPage() {
        if(empty($this->mFirstPage) || $this->mCurPageNum == 1) return NULL;
        return '<li class="page-item"><a href="?'.$this->mPageVar.'=1'.$this->mExtraVar.'" class="page-link">'.$this->mFirstPage.'</a></li>';
    }

    /**
     * 끝페이지 번호 링크를 리턴
     * @return string
     */
    public function getLastPage() {
        if(empty($this->mLastPage) || $this->mCurPageNum == $this->mPageCount) return NULL;
        return '<li class="page-item"><a href="?'.$this->mPageVar.'='.$this->mPageCount.$this->mExtraVar.'" class="page-link">'.$this->mLastPage.'</a></li>';
    }

    /**
     * 이전블럭 링크를 리턴
     * @return string
     */
    public function getPrevPerPage() {
        if(empty($this->mPrevPerPage) || $this->mBlock <= 1) return NULL;
        return '<li class="page-item"><a href="?'.$this->mPageVar.'='.$this->mFirstPerPage.$this->mExtraVar.'" class="page-link">'.$this->mPrevPerPage.'</a></li>';
    }

    /**
     * 다음블럭 링크를 리턴
     * @return string
     */
    public function getNextPerPage() {
        if(empty($this->mNextPerPage) || $this->mBlock >= $this->mTotalBlock) return NULL;
        return '<li class="page-item"><a href="?'.$this->mPageVar.'='.($this->mLastPerPage+1).$this->mExtraVar.'" class="page-link">'.$this->mNextPerPage.'</a></li>';
    }

    /**
     * 이전 페이지 링크를 리턴
     * @return string
     */
    public function getPrevPage() {
        if($this->mCurPageNum > 1)
            return '<li class="page-item"><a href="?'.$this->mPageVar.'='.($this->mCurPageNum-1).$this->mExtraVar.'" class="page-link">'.$this->mPrevPage.'</a></li>';
        else
            return '<li class="page-item"><a href="javascript:;" class="page-link">'.$this->mPrevPage.'</a></li>';
    }

    /**
     * 다음 페이지 링크를 리턴
     * @return string
     */
    public function getNextPage() {
        if($this->mCurPageNum != $this->mPageCount && $this->mPageCount)
            return '<li class="page-item"><a href="?'.$this->mPageVar.'='.($this->mCurPageNum+1).$this->mExtraVar.'" class="page-link">'.$this->mNextPage.'</a></li>';
        else
            return '<li class="page-item"><a href="javascript:;" class="page-link">'.$this->mNextPage.'</a></li>';
    }

    /**
     * 페이지 목록 링크를 리턴
     * @return string
     */
    public function getPageList() {
        $rtn = '';
        for($i=$this->mFirstPerPage+1;$i<=$this->mLastPerPage;$i++) {
            if($this->mCurPageNum == $i)
                $rtn .= '<li class="page-item '.$this->mCurPageCss.'"><a href="javascript:;" class="page-link">'.$i.'</a></li>';
            else {
                $rtn .= '<li class="page-item"><a href="?'.$this->mPageVar.'='.$i.$this->mExtraVar.'" class="page-link">'. $i .'</a></li>';
            }
        }
        return $rtn;
    }

    /**
     * 기본 페이지를 프린트, 상속후 변경 가능
     */
    public function printPaging() {
        $page_link = "";

        if($this->mTotalItem > 0) {
            $page_link .= "<ul class='pagination'>";
            //echo $this->getFirstPage();
            //echo '';
            $page_link .= $this->getPrevPerPage();
            //echo '';
            $page_link .= $this->getPrevPage();
            //echo '';
            $page_link .= $this->getPageList();
            //echo '';
            $page_link .= $this->getNextPage();
            //echo '';
            $page_link .= $this->getNextPerPage();
            //echo '';
            //echo $this->getLastPage();
            $page_link .= "</ul>";
        }
        return $page_link;
    }
}

//$paging = MongoPaging::getInstance($params);
//$paging = new MongoPaging($params);
?>