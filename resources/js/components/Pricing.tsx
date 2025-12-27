import React, { useState } from 'react';
import { useLanguage } from '@/contexts/LanguageContext';

export default function Pricing() {
  const { t } = useLanguage();
  const [billingCycle, setBillingCycle] = useState<'monthly' | 'yearly'>('monthly');

  const plans = [
    {
      name: 'Starter',
      monthlyPrice: 29,
      yearlyPrice: 290,
      description: t.pricing.features,
      features: [
        `3 ${t.pricing.features.users}`,
        `100 ${t.pricing.features.tickets}`,
        `1 ${t.pricing.features.mailboxes}`,
        `5GB ${t.pricing.features.storage}`,
        t.pricing.features.support,
      ],
      cta: t.pricing.getStarted,
      popular: false,
      gradient: 'from-gray-500 to-gray-700',
    },
    {
      name: 'Professional',
      monthlyPrice: 79,
      yearlyPrice: 790,
      description: t.pricing.features,
      features: [
        `15 ${t.pricing.features.users}`,
        `∞ ${t.pricing.features.tickets}`,
        `5 ${t.pricing.features.mailboxes}`,
        `50GB ${t.pricing.features.storage}`,
        t.pricing.features.customDomain,
        t.pricing.features.advancedReporting,
        t.pricing.features.prioritySupport,
      ],
      cta: t.pricing.getStarted,
      popular: true,
      gradient: 'from-blue-500 to-indigo-600',
    },
    {
      name: 'Enterprise',
      monthlyPrice: null,
      yearlyPrice: null,
      description: t.pricing.features,
      features: [
        t.pricing.features.unlimitedEverything,
        t.pricing.features.customDomain,
        t.pricing.features.advancedReporting,
        t.pricing.features.dedicatedSupport,
        `99.9% ${t.pricing.features.sla}`,
      ],
      cta: t.pricing.contactUs,
      popular: false,
      gradient: 'from-purple-500 to-pink-600',
    },
  ];

  const getPrice = (plan: typeof plans[0]) => {
    if (plan.monthlyPrice === null) return t.pricing.free;
    const price = billingCycle === 'monthly' ? plan.monthlyPrice : plan.yearlyPrice;
    return `$${price}`;
  };

  const getSavings = (plan: typeof plans[0]) => {
    if (plan.monthlyPrice === null || plan.yearlyPrice === null) return null;
    const monthlyCost = plan.monthlyPrice * 12;
    const savings = Math.round(((monthlyCost - plan.yearlyPrice) / monthlyCost) * 100);
    return savings;
  };

  return (
    <section id="pricing" className="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-white">
      <div className="max-w-7xl mx-auto">
        {/* Section Header */}
        <div className="text-center mb-12 sm:mb-16 animate-fade-in">
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
            {t.pricing.title}
          </h2>
          <p className="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto mb-8">
            {t.pricing.subtitle}
          </p>

          {/* Billing Toggle */}
          <div className="inline-flex items-center bg-gray-100 rounded-lg p-1">
            <button
              onClick={() => setBillingCycle('monthly')}
              className={`px-4 sm:px-6 py-2 rounded-md text-sm sm:text-base font-medium transition-all ${
                billingCycle === 'monthly'
                  ? 'bg-white text-blue-600 shadow-sm'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              {t.pricing.monthly}
            </button>
            <button
              onClick={() => setBillingCycle('yearly')}
              className={`px-4 sm:px-6 py-2 rounded-md text-sm sm:text-base font-medium transition-all ${
                billingCycle === 'yearly'
                  ? 'bg-white text-blue-600 shadow-sm'
                  : 'text-gray-600 hover:text-gray-900'
              }`}
            >
              {t.pricing.yearly}
              <span className="ml-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                {t.pricing.save} 20%
              </span>
            </button>
          </div>
        </div>

        {/* Pricing Cards */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
          {plans.map((plan, index) => (
            <div
              key={index}
              className={`relative bg-white rounded-2xl shadow-xl border-2 transition-all duration-300 hover:-translate-y-2 ${
                plan.popular
                  ? 'border-blue-500 scale-105'
                  : 'border-gray-200 hover:border-blue-300'
              }`}
            >
              {/* Popular Badge */}
              {plan.popular && (
                <div className="absolute -top-4 sm:-top-5 left-1/2 transform -translate-x-1/2">
                  <div className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 sm:px-6 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium shadow-lg">
                    Popular
                  </div>
                </div>
              )}

              <div className="p-6 sm:p-8">
                {/* Plan Name */}
                <h3 className="text-xl sm:text-2xl font-bold text-gray-900 mb-2">
                  {plan.name}
                </h3>

                {/* Price */}
                <div className="mb-6 sm:mb-8">
                  {plan.monthlyPrice === null ? (
                    <div className="text-3xl sm:text-4xl font-bold text-gray-900">
                      Custom
                    </div>
                  ) : (
                    <>
                      <div className="flex items-baseline">
                        <span className="text-4xl sm:text-5xl font-bold text-gray-900">
                          {getPrice(plan)}
                        </span>
                        <span className="text-gray-600 ml-2">{t.pricing.perMonth}</span>
                      </div>
                      {billingCycle === 'yearly' && getSavings(plan) && (
                        <div className="text-sm text-green-600 mt-1">
                          {t.pricing.save} {getSavings(plan)}%
                        </div>
                      )}
                    </>
                  )}
                </div>

                {/* CTA Button */}
                <a
                  href={plan.monthlyPrice === null ? '/contact' : '/admin/login'}
                  className={`block w-full text-center px-4 sm:px-6 py-3 sm:py-4 rounded-xl font-medium transition-all transform hover:scale-105 shadow-lg hover:shadow-xl mb-6 sm:mb-8 ${
                    plan.popular
                      ? `bg-gradient-to-r ${plan.gradient} text-white`
                      : 'bg-gray-100 text-gray-900 hover:bg-gray-200'
                  }`}
                >
                  {plan.cta}
                </a>

                {/* Features List */}
                <ul className="space-y-3 sm:space-y-4">
                  {plan.features.map((feature, featureIndex) => (
                    <li key={featureIndex} className="flex items-start">
                      <svg
                        className={`w-5 h-5 sm:w-6 sm:h-6 mr-2 sm:mr-3 flex-shrink-0 ${
                          plan.popular ? 'text-blue-500' : 'text-green-500'
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
                      <span className="text-sm sm:text-base text-gray-700">{feature}</span>
                    </li>
                  ))}
                </ul>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
