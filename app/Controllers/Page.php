<?php
    namespace Myblog2\Controllers;

    use Http\Response;
    use Myblog2\Template\Renderer;
    use Myblog2\Page\PageReader;
    use Myblog2\Page\InvalidPageException;

    class Page {
        private $response;

        private $renderer;

        private $pageReader;

        public function __construct(
            Response $response,
            Renderer $renderer,
            PageReader $pageReader
        ) {
            $this->response = $response;
            $this->renderer = $renderer;
            $this->pageReader = $pageReader;
        }

        public function show($params) {
            $slug = $params['slug'];

            try {
                $data['content'] = $this->pageReader->readBySlug($slug);
            } catch (InvalidPageException $e) {
                $this->response->setStatusCode(404);

                return $this->response->setContent('404 - Page not found');
            }
            
            $html = $this->renderer->render('page', $data);
            $this->response->setContent($html);
        }
    }
