import React from 'react';

export default function Hero() {
  return (
    <section className="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
      {/* Animated background gradients */}
      <div className="absolute inset-0 -z-10">
        <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-300/30 rounded-full blur-3xl animate-pulse"></div>
        <div className="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-300/30 rounded-full blur-3xl animate-pulse delay-1000"></div>
      </div>

      <div className="max-w-7xl mx-auto">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          {/* Left Column - Content */}
          <div className="animate-fade-in">
            <div className="inline-flex items-center space-x-2 bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-medium mb-6">
              <span className="relative flex h-2 w-2">
                <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                <span className="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
              </span>
              <span>Now Available - Start Your Free Trial</span>
            </div>

            <h1 className="text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
              Customer Support{' '}
              <span className="bg-gradient-to-r from-primary-500 to-indigo-600 bg-clip-text text-transparent">
                Made Simple
              </span>
            </h1>

            <p className="text-xl text-gray-600 mb-8 leading-relaxed">
              Transform your customer service with Helply's modern helpdesk platform.
              Multi-tenant, email integration, and powerful analytics - all in one place.
            </p>

            <div className="flex flex-col sm:flex-row gap-4">
              <a
                href="/register"
                className="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white bg-gradient-to-r from-primary-500 to-indigo-600 rounded-xl hover:from-primary-600 hover:to-indigo-700 transform hover:scale-105 transition-all shadow-xl hover:shadow-2xl"
              >
                <span className="relative z-10">Get Started Free</span>
                <svg
                  className="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M13 7l5 5m0 0l-5 5m5-5H6"
                  />
                </svg>
              </a>

              <a
                href="#demo"
                className="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:border-primary-500 hover:text-primary-600 transform hover:scale-105 transition-all shadow-lg hover:shadow-xl"
              >
                Watch Demo
                <svg
                  className="ml-2 w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                  />
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </a>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-3 gap-6 mt-12 pt-12 border-t border-gray-200">
              <div>
                <div className="text-3xl font-bold text-gray-900">99.9%</div>
                <div className="text-sm text-gray-600 mt-1">Uptime</div>
              </div>
              <div>
                <div className="text-3xl font-bold text-gray-900">24/7</div>
                <div className="text-sm text-gray-600 mt-1">Support</div>
              </div>
              <div>
                <div className="text-3xl font-bold text-gray-900">10k+</div>
                <div className="text-sm text-gray-600 mt-1">Happy Users</div>
              </div>
            </div>
          </div>

          {/* Right Column - Visual */}
          <div className="relative animate-slide-up hidden lg:block">
            <div className="relative">
              {/* Dashboard mockup */}
              <div className="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
                <div className="bg-gradient-to-r from-primary-500 to-indigo-600 p-4 flex items-center space-x-2">
                  <div className="flex space-x-2">
                    <div className="w-3 h-3 rounded-full bg-red-400"></div>
                    <div className="w-3 h-3 rounded-full bg-yellow-400"></div>
                    <div className="w-3 h-3 rounded-full bg-green-400"></div>
                  </div>
                  <div className="flex-1 text-center text-white text-sm font-medium">
                    Helply Dashboard
                  </div>
                </div>
                <div className="p-6 space-y-4">
                  <div className="flex items-center space-x-4">
                    <div className="w-12 h-12 rounded-full bg-gradient-to-r from-primary-400 to-indigo-500"></div>
                    <div className="flex-1">
                      <div className="h-4 bg-gray-200 rounded w-3/4"></div>
                      <div className="h-3 bg-gray-100 rounded w-1/2 mt-2"></div>
                    </div>
                  </div>
                  <div className="flex items-center space-x-4">
                    <div className="w-12 h-12 rounded-full bg-gradient-to-r from-purple-400 to-pink-500"></div>
                    <div className="flex-1">
                      <div className="h-4 bg-gray-200 rounded w-2/3"></div>
                      <div className="h-3 bg-gray-100 rounded w-1/3 mt-2"></div>
                    </div>
                  </div>
                  <div className="flex items-center space-x-4">
                    <div className="w-12 h-12 rounded-full bg-gradient-to-r from-green-400 to-emerald-500"></div>
                    <div className="flex-1">
                      <div className="h-4 bg-gray-200 rounded w-full"></div>
                      <div className="h-3 bg-gray-100 rounded w-2/3 mt-2"></div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Floating badges */}
              <div className="absolute -top-6 -right-6 bg-white rounded-xl shadow-xl p-4 animate-bounce">
                <div className="text-2xl font-bold text-primary-600">95%</div>
                <div className="text-xs text-gray-600">Satisfaction</div>
              </div>

              <div className="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-xl p-4">
                <div className="flex items-center space-x-2">
                  <div className="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
                  <div className="text-xs font-medium text-gray-700">Online</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
