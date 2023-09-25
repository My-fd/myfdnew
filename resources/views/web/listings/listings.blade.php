@extends('web.base')

@section('title', 'Listings')

@section('content')

<div class="hero"> 
    <div class="container">
        <div class="hero-body">
            <form class="form-box" action="{{ route('web.search') }}" method="GET">
                <div class="form-group hero-form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('Enter your search query') }}">
                </div>

                <div class="form-group hero-form-group">
                    <!-- Фильтр по городу-->
                    <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('Enter your search query') }}">
                </div>

                <button type="submit" class="btn btn-search">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="12" height="12" x="0" y="0" viewBox="0 0 464.374 464.374" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M261.284 406.263c-112.163 0-203.09-90.926-203.09-203.09S149.12.084 261.284.084s203.09 90.926 203.09 203.09-90.927 203.089-203.09 203.089zm0-348.153c-80.117 0-145.064 64.947-145.064 145.064s64.947 145.064 145.064 145.064 145.064-64.947 145.064-145.064S341.4 58.11 261.284 58.11z" fill="#ffffff" data-original="#000000" opacity="1" class=""></path><path d="M29.181 464.289a29.01 29.01 0 0 1-20.599-8.414c-11.377-11.284-11.452-29.653-.168-41.03l.168-.168L117.67 305.589c11.777-11.377 30.547-11.052 41.924.725s11.052 30.547-.725 41.924L49.78 455.875a29.01 29.01 0 0 1-20.599 8.414z" fill="#ffffff" data-original="#000000" opacity="1" class=""></path></g></svg>
                </button>
            </form>
        </div>

        <div class="hero__category">
            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

            <a href="#" class="hero__category__item">
                <span class="hero__category__item__img">
                    <img src="https://my-fd.ru/oc-content/themes/eva/img/1.png" alt="Парики">
                </span>

                <span class="hero__category__item__title">Парики</span>
            </a>

        </div>
    </div>
</div>

<div class="sections">
    <div class="container">
        <h1 class="sections__name">Последние объявления</h1>

        <div class="listings">
            
            <div class="item-wrp">                            
                <div class="item">
                    <a href="" class="item__photo">
                        <img src="" alt="фото">
                        <span class="purchased">29.08.2023</span>
                        <div class="overlay"></div>
                    </a>
                      
                    <div class="item__cat">
                        <img src=""> 
                        <div class="item__city"> Город</div>
                    </div>
        
                    <div class="item__ins" id="11">
                        <div class="item__middle-desc">
                            <a href="" class="item__title">Очень длинное название, которое может не поместиться, поэтому должно обрезаться</a>

                            <strong class="item__price">
                                 <i class="bi bi-tag-fill"></i>Цена
                            </strong>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="item-wrp">                            
                <div class="item">
                    <a href="" class="item__photo">
                        <img src="" alt="фото">
                        <span class="purchased">29.08.2023</span>
                        <div class="overlay"></div>
                    </a>
                      
                    <div class="item__cat">
                        <img src=""> 
                        <div class="item__city"> Город</div>
                    </div>
        
                    <div class="item__ins" id="11">
                        <div class="item__middle-desc">
                            <a href="" class="item__title">Очень длинное название, которое может не поместиться, поэтому должно обрезаться</a>

                            
                            <strong class="item__price">
                                 <i class="bi bi-tag-fill"></i>Цена
                            </strong>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="item-wrp">                            
                <div class="item">
                    <a href="" class="item__photo">
                        <img src="" alt="фото">
                        <span class="purchased">29.08.2023</span>
                        <div class="overlay"></div>
                    </a>
                      
                    <div class="item__cat">
                        <img src=""> 
                        <div class="item__city"> Город</div>
                    </div>
        
                    <div class="item__ins" id="11">
                        <div class="item__middle-desc">
                            <a href="" class="item__title">Очень длинное название, которое может не поместиться, поэтому должно обрезаться</a>

                            
                            <strong class="item__price">
                                 <i class="bi bi-tag-fill"></i>Цена
                            </strong>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="item-wrp">                            
                <div class="item">
                    <a href="" class="item__photo">
                        <img src="" alt="фото">
                        <span class="purchased">29.08.2023</span>
                        <div class="overlay"></div>
                    </a>
                      
                    <div class="item__cat">
                        <img src=""> 
                        <div class="item__city"> Город</div>
                    </div>
        
                    <div class="item__ins" id="11">
                        <div class="item__middle-desc">
                            <a href="" class="item__title">Очень длинное название, которое может не поместиться, поэтому должно обрезаться</a>

                            
                            <strong class="item__price">
                                 <i class="bi bi-tag-fill"></i>Цена
                            </strong>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="item-wrp">                            
                <div class="item">
                    <a href="" class="item__photo">
                        <img src="" alt="фото">
                        <span class="purchased">29.08.2023</span>
                        <div class="overlay"></div>
                    </a>
                      
                    <div class="item__cat">
                        <img src=""> 
                        <div class="item__city"> Город</div>
                    </div>
        
                    <div class="item__ins" id="11">
                        <div class="item__middle-desc">
                            <a href="" class="item__title">Очень длинное название, которое может не поместиться, поэтому должно обрезаться</a>

                            
                            <strong class="item__price">
                                 <i class="bi bi-tag-fill"></i>Цена
                            </strong>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="item-wrp">                            
                <div class="item">
                    <a href="" class="item__photo">
                        <img src="" alt="фото">
                        <span class="purchased">29.08.2023</span>
                        <div class="overlay"></div>
                    </a>
                      
                    <div class="item__cat">
                        <img src=""> 
                        <div class="item__city"> Город</div>
                    </div>
        
                    <div class="item__ins" id="11">
                        <div class="item__middle-desc">
                            <a href="" class="item__title">Очень длинное название, которое может не поместиться, поэтому должно обрезаться</a>

                            
                            <strong class="item__price">
                                 <i class="bi bi-tag-fill"></i>Цена
                            </strong>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="item-wrp">                            
                <div class="item">
                    <a href="" class="item__photo">
                        <img src="" alt="фото">
                        <span class="purchased">29.08.2023</span>
                        <div class="overlay"></div>
                    </a>
                      
                    <div class="item__cat">
                        <img src=""> 
                        <div class="item__city"> Город</div>
                    </div>
        
                    <div class="item__ins" id="11">
                        <div class="item__middle-desc">
                            <a href="" class="item__title">Очень длинное название, которое может не поместиться, поэтому должно обрезаться</a>

                            
                            <strong class="item__price">
                                 <i class="bi bi-tag-fill"></i>Цена
                            </strong>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </div>
</div>


@endsection
