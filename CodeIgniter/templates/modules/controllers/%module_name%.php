<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listing extends MX_Controller {

	//constructor
	public function __construct() {
        parent::__construct();
		$this->load->model('special_Search_model');
		$this->load->model('new_property_model');
    }
	
	public function perumahan_baru() {
		
		$vdata['data'] = $this->new_property_model->getRandom(3);
		
		$this->load->view('slide_perumahan_baru', $vdata);
	}
	
	public function perumahan_baru_rotate() {
		
		$vdata['data'] = $this->new_property_model->getRandom(3);
		
		$this->load->view('random_perumahan_baru', $vdata);
	}
	
	public function default_listing($offset = 0, $perpage = 10) {
		
	
		//load library
		$this->load->library(array('pagination'));
		
		//load model
		$this->load->model('search_model');
		$this->load->model('rumah_model');
		$this->load->model('agent_model');
		

		if ($this->input->post('sort_by')) {
			$this->session->unset_userdata('sort');
			$this->session->set_userdata('sort', $this->input->post('sort_by'));
		}
		else {
			if (!$this->session->userdata('sort')) {
				$this->session->set_userdata('sort', 'terbaru');
			}
		}
		
		$params['order_val'] = $this->session->userdata('sort');
		$this->lang->load('all', 'indonesia');
		
		$params['type'] = 'house';
		$page = 0;
		$perpage = 5;
		$params['category'] = 's';
		
		$paging_url = generatePagingURL($_SERVER['QUERY_STRING']);
		$config['base_url'] = base_url().'listing/';
		$config['uri_segment'] = 2;
		$config['num_links'] = 4;
		$config['total_rows'] = $this->search_model->count_solr($params);
		$config['per_page'] = $perpage;
		$config['last_link'] = FALSE;
		$config['first_link'] = FALSE;
		$config['next_link'] = 'Selanjutnya &raquo;';
		$config['prev_link'] = '&laquo; Sebelumnya';
		$config['anchor_class'] = 'class="yltasis" ';
		$config['first_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="first">';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="last">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="current unlinked"><span>';
		$config['cur_tag_close'] = '</span></li>';

		$data['total_result'] = $config['total_rows'];
		
		$this->pagination->initialize($config);
		
		if (empty($offset)) {
			$offset = 0;
		}
		//End of Pagination configuration
		

		$data['pagination'] = $this->pagination->create_links();
		//echo'<pre>';print_r($data);echo'</pre>';
		//End of Paging Formatting
		
		$page = !empty($_GET['page']) ? $_GET['page'] : 1;
		$datas = $this->search_model->solr('*', $params, $offset, $page, $config['per_page']);
		$data['list_all'] = $datas['data'];
		$this->session->set_userdata('total_rows', $datas['numFound']);
		
		//get agent data
		if(!empty($data['list_all'])) {
			foreach($data['list_all'] as $key => $item) {
				
				$agent = $this->agent_model->getAgentDetailPersonalData($item['agent'], 'solr');			
				$data['list_all'][$key]['user'] = !empty($agent)?$agent:array();
			}
		}
		
		$data['module']		= 'house';
		$data['sorting_form'] = Modules::run('search/search/sorting_form', 'house');
		$this->load->view('default_listing', $data);
	}
}

/* End of file search.php */
/* Location: ./application/modules/search/controllers/search.php */