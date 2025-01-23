<?php

$template = '
  <div class="col-12 col-md-6 col-lg-4">
      <div class="d-flex flex-wrap flex-column border rounded-0 bg-white h-100">
        <div class="w-100">
          <div class="row g-0 justify-content-between">
            <div class="col-8">
              <div class="pt-2 px-3 fs-6 fw-bold text-dark text-break">
                {{name}}
              </div>
            </div>
            <div class="col-auto">
              <div class="pt-2 px-3 fs-7 text-secondary">
                {{code}}
              </div>
            </div>
            <div class="col-12">
              <div class="pt-2 px-3 pb-3 text-secondary fs-8">
                <div class="d-flex align-items-center pb-1">
                  <div
                    style="
                      background-color: {{color}};
                      width: 16px;
                      height: 16px;
                      border-radius: 50%;
                    ">
                  </div>
                  <div class="ps-2 text-truncate">{{color}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-auto w-100">
          <div class="pb-3 px-3 fs-8">
            <div class="row g-1">
              <div class="col-12">
                <div class="text-truncate">
                  <a href="{{site}}" class="text-rn-link" target="_blank">{{site}}</a>
                </div>
              </div>
              <div class="col-12">
                <div class="text-truncate">
                  <a href="{{manage}}" class="text-rn-link" target="_blank">{{manage}}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  ';
  /*
  <div class="mt-auto w-100">
    <div class="d-flex">
      <div class="w-100 border-top">
        <a
          href="{{site}}"
          class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
          target="_blank">
          Website
        </a>
      </div>
      <div class="w-100 border-top border-start">
        <a
          href="{{manage}}"
          class="btn btn-outline-primary border-0 w-100 fs-8 rounded-0 py-2"
          target="_blank">
          Manage
        </a>
      </div>
    </div>
  </div>
  */