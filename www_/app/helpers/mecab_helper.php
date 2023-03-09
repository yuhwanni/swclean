<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

function crmecab_analysis_str( $str )
{
    /** @noinspection PhpUndefinedFunctionInspection */
    $mecab = mecab_new( null, true );

    $arr_res = array();

    /*
    function noun_filter($node_info)
    {
        var_dump($node_info);
        return $node_info['posid'] >= 37 && $node_info['posid'] <= 66;
    }

    //$ret[ 'chat' ] = mecab_sparse_tostr( $mecab, $str );
    var_dump( mecab_split( $str, null, null, 'noun_filter', true ) );
    /*/
    /** @noinspection PhpUndefinedFunctionInspection */
    $m = mecab_sparse_tonode($mecab, $str);

    $arr_feat_kind = array( 'part', 'mean_kind', 'is_exist_last_char', 'read', 'type', 'f_part', 'l_part', 'orgin', 'exp_index' );

    while ($m) {
        //writeln(mecab_node_surface($m) . "\t" . mecab_node_feature($m));

        $node = new stdClass();
        /** @noinspection PhpUndefinedFunctionInspection */
        $node->word = mecab_node_surface( $m );
        /** @noinspection PhpUndefinedFunctionInspection */
        $feat = explode( ',', mecab_node_feature( $m ) );

        $cnt_feat = count( $feat );

        for ( $i = 0; $i < $cnt_feat; ++$i )
        {
            $node->{ $arr_feat_kind[ $i ] } = $feat[ $i ];
        }

        array_push( $arr_res, $node );
        /** @noinspection PhpUndefinedFunctionInspection */
        $m = mecab_node_next($m);
    }
    //*/
    /** @noinspection PhpUndefinedFunctionInspection */
    mecab_destroy( $mecab );

    return $arr_res;
}

function crmecab_part_info()
{
    // 품사별 정보( 품사명, 가중치, 참조테이블 )
    $arr_part = array(
        'NNG' => array( '일반 명사', 2, 'dict_noun' ),
        'NNP' => array( '고유 명사', 5, 'dict_propernoun' ),
        'NNB' => array( '의존 명사', 0, '' ),
        'NNBC' => array( '단위를 나타내는 명사', 0, '' ),
        'NR' => array( '수사', 0, '' ),
        'NP' => array( '대명사', 0, '' ),
        'VV' => array( '동사', 10, 'dict_verb' ),
        'VA' => array( '형용사', 5, 'dict_verb' ),
        'VX' => array( '보조 용언', 2, 'dict_verb' ),
        'VCP' => array( '긍정 지정사', 1, ''  ),
        'VCN' => array( '부정 지정사', 0, '' ),
        'MM' => array( '관형사', 0, '' ),
        'MAG' => array( '일반 부사', 0, '' ),
        'MAJ' => array( '접속 부사', 0, '' ),
        'IC' => array( '감탄사', 0, '' ),
        'JKS' => array( '주격 조사', 0, '' ),
        'JKC' => array( '보격 조사', 0, '' ),
        'JKG' => array( '관형격 조사', 0, '' ),
        'JKO' => array( '목적격 조사', 0, '' ),
        'JKB' => array( '부사격 조사', 0, '' ),
        'JKV' => array( '호격 조사', 0, '' ),
        'JKQ' => array( '인용격 조사', 0, '' ),
        'JX' => array( '보조사', 0, '' ),
        'JC' => array( '접속 조사', 0, '' ),
        'EP' => array( '선어말 어미', 0, '' ),
        'EF' => array( '종결 어미', 0, '' ),
        'EC' => array( '연결 어미', 0, '' ),
        'ETN' => array( '명사형 전성 어미', 0, '' ),
        'ETM' => array( '관형형 전성 어미', 0, '' ),
        'XPN' => array( '체언 접두사', 0, '' ),
        'XSN' => array( '명사 파생 접미사', 0, '' ),
        'XSV' => array( '동사 파생 접미사', 0, '' ),
        'XSA' => array( '형용사 파생 접미사', 0, '' ),
        'XR' => array( '어근', 0, '' ),
        'SF' => array( '마침표, 물음표, 느낌표', 0, '' ),
        'SE' => array( '줄임표', 0, '' ),
        'SY' => array( '기호', 0, '' ),
        'SSO' => array( '여는 괄호 (, [', 0, '' ),
        'SSC' => array( '닫는 괄호 ), ]', 0, '' ),
        'SL' => array( '외국어', 0, '' ),
        'SH' => array( '한자', 0, '' ),
        'SN' => array( '숫자', 0, '' ),
        'VV+EC' => array( '연결동사', 10, 'dict_verb' ),
        'VV+EF' => array( '종결동사', 10, 'dict_verb' ),
        'VV+EP' => array( '선어말동사', 10, 'dict_verb' )
    );

    return $arr_part;
}

function crmecab_parsing_node( $node )
{
    $arr_part = crmecab_part_info();

    $ret = '';

    if ( array_key_exists( $node->part, $arr_part ) )
    {
        //$ret = $arr_part[ $node->part ][ 0 ] . ' => ' . $node->word;
        $ret[ 'desc' ] = '<span style="color:#0000ff">' . $node->word . '</span>(' . $arr_part[ $node->part ][ 0 ] . ') ';
        $ret[ 'word' ] = $node->word;
        $ret[ 'part' ] = $node->part;
        $ret[ 'part_kor' ] = $arr_part[ $node->part ][ 0 ];
        $ret[ 'point' ] = $arr_part[ $node->part ][ 1 ];
        $ret[ 'table' ] = $arr_part[ $node->part ][ 2 ];
    }
    else
    {
        if ( $node->part == 'BOS/EOS' )
        {
            $ret[ 'desc' ] = '';
            $ret[ 'word' ] = '';
            $ret[ 'part' ] = '';
            $ret[ 'part_kor' ] = '';
            $ret[ 'point' ] = 0;
            $ret[ 'table' ] = '-';
        }
        else
        {
            //$ret = 'Not Set : ' . $node->part . ' => ' . $node->word;
            $ret[ 'desc' ] = '<span style="color:#ff0000">' . $node->word . '</span>(notf-' . $node->part . ') ';
            $ret[ 'word' ] = $node->word;
            $ret[ 'part' ] = $node->part;
            $ret[ 'part_kor' ] = '';
            $ret[ 'point' ] = 0;
            $ret[ 'table' ] = 'dict_newword';
        }
    }

    return $ret;
}

function mecab_next_node( $arr_words, $total_cnt, $cur_idx )
{
    $next = $cur_idx + 1;

    if ( $next < $total_cnt )
    {
        return $arr_words[ $next ];
    }

    return null;
}

function mecab_prev_node( $arr_words, /** @noinspection PhpUnusedParameterInspection */
                          $total_cnt, $cur_idx )
{
    if ( $cur_idx == 0 ) return null;

    $next = $cur_idx - 1;

    return $arr_words[ $next ];
}
