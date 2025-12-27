import React from 'react';

export default function Pricing() {
  const plans = [
    {
      name: 'Starter',
      price: '29',
      description: 'Perfect for small teams getting started',
      features: [
        'Up to 3 team members',
        '100 tickets/month',
        'Email integration',
        'Basic analytics',
        'Mobile app access',
        'Community support',
      ],
      cta: 'Start Free Trial',
      popular: false,
      gradient: 'from-gray-500 to-gray-700',
    },
    {
      name: 'Professional',
      price: '79',
      description: 'For growing businesses with more needs',
      features: [
        'Up to 15 team members',
        'Unlimited tickets',
        'Advanced email routing',
        'Advanced analytics & reports',
        'Live chat widget',
        'SLA management',
        'API access',
        'Priority support',
      ],
      cta: 'Start Free Trial',
      popular: true,
      gradient: 'from-primary-500 to-indigo-600',
    },
    {
      name: 'Enterprise',
      price: 'Custom',
      description: 'For large organizations with custom needs',
      features: [
        'Unlimited team members',
        'Unlimited everything',
        'Custom domain',
        'White-label solution',
        'Advanced security',
        'Custom integrations',
        'Dedicated support',
        'SLA guarantee',
      ],
      cta: 'Contact Sales',
      popular: false,
      gradient: 'from-purple-500 to-pink-600',
    },
  ];

  return (
    <section id="pricing" className="py-20 px-4 sm:px-6 lg:px-8 bg-white">
      <div className="max-w-7xl mx-auto">
        {/* Section Header */}
        <div className="text-center mb-16 animate-fade-in">
          <h2 className="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
            Simple,{' '}
            <span className="bg-gradient-to-r from-primary-500 to-indigo-600 bg-clip-text text-transparent">
              transparent pricing
            </span>
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            No hidden fees. Cancel anytime. All plans include a 14-day free trial.
          </p>
        </div>

        {/* Pricing Cards */}
        <div className="grid md:grid-cols-3 gap-8 lg:gap-12">
          {plans.map((plan, index) => (
            <div
              key={index}
              className={`relative bg-white rounded-2xl shadow-xl border-2 transition-all duration-300 hover:-translate-y-2 ${
                plan.popular
                  ? 'border-primary-500 scale-105'
                  : 'border-gray-200 hover:border-primary-300'
              }`}
            >
              {/* Popular Badge */}
              {plan.popular && (
                <div className="absolute -top-5 left-1/2 transform -translate-x-1/2">
                  <div className="bg-gradient-to-r from-primary-500 to-indigo-600 text-white px-6 py-2 rounded-full text-sm font-medium shadow-lg">
                    Most Popular
                  </div>
                </div>
              )}

              <div className="p-8">
                {/* Plan Name */}
                <h3 className="text-2xl font-bold text-gray-900 mb-2">
                  {plan.name}
                </h3>
                <p className="text-gray-600 mb-6">{plan.description}</p>

                {/* Price */}
                <div className="mb-8">
                  {plan.price === 'Custom' ? (
                    <div className="text-4xl font-bold text-gray-900">
                      Custom
                    </div>
                  ) : (
                    <div className="flex items-baseline">
                      <span className="text-5xl font-bold text-gray-900">
                        ${plan.price}
                      </span>
                      <span className="text-gray-600 ml-2">/month</span>
                    </div>
                  )}
                </div>

                {/* CTA Button */}
                <a
                  href={plan.price === 'Custom' ? '/contact' : '/register'}
                  className={`block w-full text-center px-6 py-4 rounded-xl font-medium transition-all transform hover:scale-105 shadow-lg hover:shadow-xl mb-8 ${
                    plan.popular
                      ? `bg-gradient-to-r ${plan.gradient} text-white`
                      : 'bg-gray-100 text-gray-900 hover:bg-gray-200'
                  }`}
                >
                  {plan.cta}
                </a>

                {/* Features List */}
                <ul className="space-y-4">
                  {plan.features.map((feature, featureIndex) => (
                    <li key={featureIndex} className="flex items-start">
                      <svg
                        className={`w-6 h-6 mr-3 flex-shrink-0 ${
                          plan.popular ? 'text-primary-500' : 'text-green-500'
                        }`}
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          strokeLinecap="round"
                          strokeLinejoin="round"
                          strokeWidth={2}
                          d="M5 13l4 4L19 7"
                        />
                      </svg>
                      <span className="text-gray-700">{feature}</span>
                    </li>
                  ))}
                </ul>
              </div>
            </div>
          ))}
        </div>

        {/* Additional Info */}
        <div className="mt-16 text-center">
          <p className="text-gray-600 mb-4">
            All plans include our core features and 99.9% uptime guarantee
          </p>
          <div className="flex flex-wrap justify-center gap-8 text-sm text-gray-500">
            <div className="flex items-center">
              <svg className="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
              No credit card required
            </div>
            <div className="flex items-center">
              <svg className="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
              14-day free trial
            </div>
            <div className="flex items-center">
              <svg className="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
              Cancel anytime
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
